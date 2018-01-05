<?php

class SqlSelect
{
	private function __construct()
	{
	}

	/**
	 * SQL実行
	 *
	 * @param string $sql 実行するSQL
	 * @param array $paramList バインドするパラメータのリスト
	 * @return 実行したSQLの結果
	 */
	public static function fetchAll($sql, $paramList = array())
	{
		$dbh = DBConnection::getDbh();

		if (empty($paramList))
		{
			// SQL実行
			$stmt = $dbh->query($sql);
		}
		else
		{
			// SQL設定
			$stmt = $dbh->prepare($sql);

			foreach ($paramList as $key => $value)
			{
				// int型のパラメータの場合、第3引数を設定
				if (gettype($value) == 'integer')
				{
					$stmt->bindValue($key, $value, PDO::PARAM_INT);
				}
				else
				{
					$stmt->bindValue($key, $value);
				}
			}

			// SQL実行
			$stmt->execute();
		}

		// 実行結果取得
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// 解放
		$stmt->closeCursor();
		$stmt = null;

		$dbh = null;

		return $data;
	}

	/**
	 * SQL実行：トランザクション引き渡し用
	 *
	 * @param connection $dbh DBコネクション
	 * @param string $sql 実行するSQL
	 * @param array $paramList バインドするパラメータのリスト
	 * @return 実行したSQLの結果
	 */
	public static function fetchAllForTrans($dbh, $sql, $paramList = array())
	{
		// SQL設定
		$stmt = $dbh->prepare($sql);

		foreach ($paramList as $key => $value)
		{
			// int型のパラメータの場合、第3引数を設定
			if (gettype($value) == 'integer')
			{
				$stmt->bindValue($key, $value, PDO::PARAM_INT);
			}
			else
			{
				$stmt->bindValue($key, $value);
			}
		}

		// SQL実行
		$stmt->execute();

		// 実行結果取得
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// 解放
		$stmt->closeCursor();
		$stmt = null;

		return $data;
	}

}