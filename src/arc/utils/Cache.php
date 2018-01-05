<?php

class Cache
{
	/** memcachedサーバ情報 */
	private static $_serverList = null;

	/** memcachedインスタンス */
	private static $_memcached = null;

	public function __construct()
	{
		if (!extension_loaded('memcached'))
		{
			throw new Exception('The Memcached Extension must be loaded to use Memcached Cache.');
		}

		if (is_null(self::$_serverList))
		{
			self::$_serverList = WrapSpyc::getValueArray('memcached');
		}

		if (is_null(self::$_memcached))
		{
			self::$_memcached = new Memcached();

			foreach (self::$_serverList as $key => $server)
			{
				self::$_memcached->addServer($server['host'], $server['port'], $server['weight']);
			}
		}
	}

	public function get($id)
	{
		$data = self::$_memcached->get($id);

		return (is_array($data)) ? $data[0] : null;
	}

	public function save($id, $data, $ttl = 60)
	{
		return self::$_memcached->add($id, array($data, time(), $ttl), $ttl);
	}

	public function delete($id)
	{
		return self::$_memcached->_memcached->delete($id);
	}

	public function clean()
	{
		return self::$_memcached->flush();
	}

	public function cacheInfo()
	{
		return self::$_memcached->getStats();
	}

	public function getMetaData($id)
	{
		$stored = self::$_memcached->get($id);

		if (count($stored) !== 3)
		{
			return null;
		}

		list($data, $time, $ttl) = $stored;

		return array(
			'expire'	=> $time + $ttl,
			'mtime'		=> $time,
			'data'		=> $data
		);
	}

}