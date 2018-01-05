<?php

abstract class AbstractSql
{
	public function __construct()
	{
	}

	protected $isCache = false;
	protected $cacheExpires = false;

	/**
	 * オーバーライドしてトランザクション内のクエリ処理を記述
	 *
	 * @param connection $dbh DBコネクション
	 * @return bool 成功：true / 失敗：false
	 */
	protected function virtualQuery($dbh)
	{
		return false;
	}

	/**
	 * SQL実行：トランザクション
	 *
	 * @return 実行したSQLの結果
	 */
	public function queryForTrans($method = null)
	{
		$result = null;

		// コネクション取得
		$dbh = DBConnection::getDbh();

		try
		{
			// トランザクション開始
			$dbh->beginTransaction();

			if (is_null($method))
			{
				// SQL実行
				$result = $this->virtualQuery($dbh);
			}
			else
			{
				if (!in_array($method, get_class_methods($this)))
				{
					throw new PDOException('実行するメソッドが見つかりません。');
				}

				// SQL実行
				$result = $this->{$method}($dbh);
			}

			// トランザクションコミット
			$dbh->commit();

			$stmt = null;
			$dbh = null;
		}
		catch (PDOException $ex)
		{
			// トランザクションロールバック
			$dbh->rollBack();

			$stmt = null;
			$dbh = null;

			// 例外をベースになげる
			throw $ex;
		}

		return $result;
	}

	protected function loadCacheSetting($key)
	{
		$cacheYaml = WrapSpyc::getValueArray('cache');
		$cacheSetting = $cacheYaml[$key];

		if ($cacheSetting !== false)
		{
			$this->isCache = true;
		}

		if ($cacheSetting !== 0)
		{
			$this->cacheExpires = $cacheSetting;
		}
	}

	protected function createCacheKey($data)
	{
		return sha1(get_called_class() . serialize($data));
	}

	protected function getCache($key)
	{
		$result = null;

		if (!$this->isCache)
		{
			return $result;
		}

		try
		{
			$result = (new Cache())->get($key);
		}
		catch (Exception $ex)
		{
		}

		return $result;
	}

	protected function setCache($key, $data, $expires)
	{
		if (!$this->isCache)
		{
			return;
		}

		try
		{
			(new Cache())->save($key, $data, $expires);
		}
		catch (Exception $ex)
		{
			var_dump($ex);exit;
			Logger::except($ex);
		}
	}

	protected function virtualFindCache($data)
	{
		return null;
	}

	public function findCache($data, $method = null)
	{
		$key = $this->createCacheKey($data);

		$result = $this->getCache($key);

		if (!is_null($result))
		{
			return $result;
		}

		if (is_null($method))
		{
			$result = $this->virtualFindCache($data);
		}
		else
		{
			if (!in_array($method, get_class_methods($this)))
			{
				throw new Exception('実行するメソッドが見つかりません。');
			}

			$result = $this->{$method}($data);
		}

		if (!is_null($result))
		{
			$this->setCache($key, $result, $this->cacheExpires);
		}

		return $result;
	}

}