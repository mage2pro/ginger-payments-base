<?php
namespace Df\GingerPaymentsBase;
use Df\Core\Exception as DFE;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException as ERequest;
final class Api {
	/**
	 * 2017-02-25
	 * @used-by \Df\GingerPaymentsBase\Settings::api()
	 * @param Method $m
	 */
	function __construct(Method $m) {$this->_guzzle = new HttpClient([
		'auth' => [$m->s()->privateKey(), '']
		// 2017-03-08
		// https://github.com/mage2pro/ginger-payments/blob/0.2.1/etc/config.xml?ts=4#L11
		// https://github.com/mage2pro/kassa-compleet/blob/0.2.1/etc/config.xml?ts=4#L11
		,'base_uri' => "https://api.{$m->s('apiDomain')}/v1/"
		,'headers' => ['User-Agent' => df_cc_s(
			'Mage2.PRO', $m->titleB(), df_package_version($m)
		)] + df_headers()
		,'timeout' => 10
	]);}

	/**
	 * 2017-03-04
	 * @used-by \Df\GingerPaymentsBase\ConfigProvider::config()
	 * @used-by \Df\GingerPaymentsBase\T\GetIdealBanks::t01()
	 * @return array(string => string)
	 */
	function idealBanks() {return array_column($this->req('ideal/issuers/'), 'name', 'id');}

	/**
	 * 2017-02-26
	 * @used-by \Df\GingerPaymentsBase\Method::getConfigPaymentAction()
	 * @return string
	 */
	function lastResponse() {return $this->_lastResponse;}

	/**
	 * 2017-03-09
	 * @param string $id The order ID.
	 * @return array(string => mixed)
	 */
	function orderGet($id) {return $this->req("orders/$id");}

	/**
	 * 2017-02-27
	 * @used-by \Df\GingerPaymentsBase\Method::getConfigPaymentAction()
	 * @param array(string => mixed) $o
	 * @return array(string => mixed)
	 */
	function orderPost(array $o) {return $this->req('orders/', 'post', [
		'body' => json_encode($o)
		,'headers' => ['Content-Type' => 'application/json']
	]);}

	/**
	 * 2017-03-09
	 * @param array(string => mixed) $o
	 * @return array(string => mixed)
	 */
	function orderUpdate(array $o) {return $this->putOrder($o);}

	/**
	 * 2017-03-01
	 * https://www.gingerpayments.com/docs#_merchants
	 * [Ginger Payments] Why does a «GET merchants/self/projects/self/» request
	 * lead to the «You don't have the permission to access the requested resource» response?
	 * https://mage2.pro/t/3457
	 *
	 * [Kassa Compleet] The «merchants/» API part is undocumented: https://mage2.pro/t/3459
	 * [Kassa Compleet] An example of a response to «GET merchants/self/projects/self/»
	 * https://mage2.pro/t/3458
	 *
	 * @used-by \Df\GingerPaymentsBase\T\GetMerchant::t01()
	 *
	 * @param string $mId [optional]
	 * @param string $pId [optional]
	 * @return array
	 */
	function products($mId = 'self', $pId = 'self') {return $this->req("merchants/{$mId}/projects/{$pId}/");}

	/**
	 * 2017-03-09
	 * @param array(string => mixed) $o
	 * @return array(string => mixed)
	 */
	private function putOrder(array $o) {return $this->req(
		"orders/{$o['id']}/", 'put', ['timeout' => 10, 'json' => $o])
	;}

	/** @noinspection PhpInconsistentReturnPointsInspection */
	/**
	 * 2017-02-26
	 * @param string $uri
	 * @param string $method [optional]
	 * @param array(string => mixed) $params
	 * @return array(string => mixed)
	 * @throws DFE
	 */
	private function req($uri, $method = 'get', $params = []) {
		try {
			/** @var array(string => mixed) $result */
			$result = df_json_decode((string)$this->_guzzle->request($method, $uri, $params)->getBody());
			// 2017-02-26
			// Намеренно выполняем двойное кодирование-декодирование,
			// чтобы привести форматирование JSON к удобному для нас виду.
			$this->_lastResponse = df_json_encode_pretty($result);
			return $result;
		}
		catch (ERequest $e) {
			df_error((string)$e->getResponse()->getBody());
		}
	}

	/**
	 * 2017-02-26   
	 * @used-by __construct()
	 * @used-by req()
	 * @var HttpClient
	 */
	private $_guzzle;

	/**
	 * 2017-02-26
	 * @used-by lastResponse()
	 * @used-by req()
	 * @var string
	 */
	private $_lastResponse;
}