<?php

class File
{
	/**
	 * ファイル取得
	 *
	 * @param string $path
	 * @return string
	 */
	public static function get($path)
	{
		$result = false;

		if (file_exists($path))
		{
			$result = file_get_contents($path);
		}

		if (!$result) throw new Exception('ファイル取得に失敗しました。$path->' . $path);

		return $result;
	}

	/**
	 * ファイル出力
	 *
	 * @param string $path
	 * @param int
	 */
	public static function put($path, $data)
	{
		$result = file_put_contents($path, $data);

		if (!$result) throw new Exception('ファイル出力に失敗しました。$path->' . $path);

		return $result;
	}

	/**
	 * ファイルコピー
	 *
	 * @param string $path
	 * @param string $dest
	 */
	public static function copy($path, $dest)
	{
		if (!copy($path, $dest))
		{
			throw new Exception('ファイルコピーに失敗しました。$path->' . $path);
		}
	}

	/**
	 * ファイル削除
	 *
	 * @param string $path 削除するファイルのディレクトリ
	 * @param int $deadLine 削除期限
	 * @return array 削除に失敗したファイルのリスト
	 */
	public function remove($path, $deadLine)
	{
		$result = array();

		$dirIterator = new RecursiveDirectoryIterator($path);

		foreach ($iterator = new RecursiveIteratorIterator(
			$dirIterator, RecursiveIteratorIterator::SELF_FIRST) as $file)
		{
			$fileName = $file->getPathname();

			// 期限を経過したファイルを削除
			if((time() - filemtime($file->getPathname()) > $deadLine))
			{
				// 削除に失敗した場合、リストに追加する
				if(!unlink($fileName))
				{
					array_push($result, $fileName);
				}
			}
		}

		return $result;
	}
}