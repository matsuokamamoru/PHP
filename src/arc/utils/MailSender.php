<?php

class MailSender
{
	public function __construct()
	{
	}

	/**
	 * メール送信実行
	 *
	 * @param string $mail_contents
	 * @param string $mailto
	 * @param string $mail_from_name
	 * @param string $replayTo
	 * @param string $returnPath
	 * @param string $additionalHeader
	 * @return boolean
	 */
	public function sendMailExecute(
			$mail_contents, $mailto, $mail_from_name,
			$replayTo = null, $returnPath = null, $additionalHeader = null)
	{
		mb_internal_encoding('UTF-8');
		mb_language('japanese');

		if (is_null($replayTo))
		{
			$replayTo = $mail_contents['From'];
		}

		if (is_null($returnPath))
		{
			$returnPath = $mail_contents['From'];
		}

		$messageId = time();

		$from  = mb_encode_mimeheader(mb_convert_encoding($mail_from_name, 'JIS', 'UTF-8')) . '<' . $mail_contents['From'] . '>';

		$header  = 'From: $from \r\n';
		$header .= 'Reply-To: {$replayTo}\r\n';
		$header .= 'Message-ID: {$messageId}\r\n';
		$header .= 'MIME-Version: 1.0\r\n';
		$header .= 'Content-Type: text/plain;charset=\'ISO-2022-JP\'\r\n';
		$header .= 'Content-Transfer-Encoding: 7bit\r\n';

		if (preg_match('/(softbank\.ne\.jp)|(vodafone\.ne\.jp)$/',$mailto))
		{
			$_subject = mb_encode_mimeheader(mb_convert_encoding($mail_contents['Subject'], 'JIS', 'UTF-8'), 'ISO-2022-JP');
			$_body = mb_convert_encoding($mail_contents['contents'], 'JIS', 'UTF-8');
		}
		else
		{
			$_subject = '=?ISO-2022-JP?B?' . base64_encode(mb_convert_encoding($mail_contents['Subject'], 'JIS', 'UTF-8')) . '?=';
			$_body = mb_convert_encoding($mail_contents['contents'], 'JIS', 'UTF-8');
		}

		$_body = preg_replace('{\r\n|\r|\n}', '\r\n', $_body);
		$header .= 'X-Mailer:PHP/' . phpversion() . '\r\n';
		$header .= $additionalHeader;
		$result = mail($mailto, $_subject, $_body, $header, '-f {$returnPath}');

		return $result;
	}
}