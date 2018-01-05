<?php

class SqlExec
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
	public static function query($sql, $paramList = array())
	{
		$result = null;

		// コネクション取得
		$dbh = DBConnection::getDbh();

		try
		{
			// トランザクション開始
			$dbh->beginTransaction();

			// SQL設定
			$stmt = $dbh->prepare($sql);

			// パラメータバインド
			foreach ($paramList as $key => $value)
			{
				$stmt->bindValue($key, $value);
			}

			// SQL実行
			$result = $stmt->execute();

			// 解放
			$stmt->closeCursor();

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

	/**
	 * SQL実行：トランザクション引き渡し用
	 *
	 * @param connection $dbh DBコネクション
	 * @param string $sql 実行するSQL
	 * @param array $paramList バインドするパラメータのリスト
	 * @return 実行したSQLの結果
	 */
	public static function queryForTrans($dbh, $sql, $paramList = array())
	{
		$result = null;

		// SQL設定
		$stmt = $dbh->prepare($sql);

		// パラメータバインド
		foreach ($paramList as $key => $value)
		{
			$stmt->bindValue($key, $value);
		}

		// SQL実行
		$result = $stmt->execute();

		// 解放
		$stmt->closeCursor();
		$stmt = null;

		return $result;
	}

}