<?php
namespace Dfe\GingerPaymentsBase;
use Df\Core\Exception as DFE;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException as ERequest;
final class Api {
	/**
	 * 2017-02-25
	 * @used-by \Dfe\GingerPaymentsBase\Method::api()
	 */
	function __construct(Method $m) {$this->_guzzle = new HttpClient([
		'auth' => [$m->s()->privateKey(), '']
		# 2017-03-08
		# https://github.com/mage2pro/ginger-payments/blob/0.2.1/etc/config.xml?ts=4#L11
		# https://github.com/mage2pro/kassa-compleet/blob/0.2.1/etc/config.xml?ts=4#L11
		,'base_uri' => "https://api.{$m->s()->domain()}/v1/"
		,'headers' => ['User-Agent' => df_cc_s('Mage2.PRO', $m->titleB(), df_package_version($m))] + df_headers()
		,'timeout' => 10
	]);}

	/**
	 * 2017-03-04     
	 * 2017-03-05 I make the banks names in the test mode more real (and shorter).
	 * @used-by \Dfe\GingerPaymentsBase\ConfigProvider::config()
	 * @used-by \Dfe\GingerPaymentsBase\Test\GetIdealBanks::t01()
	 * @return array(string => string)
	 */
	function idealBanks():array {return dfc($this, function():array {return
		['INGBNL2A' => __('ING Bank'), 'RABONL2U' => __('Rabobank')]
		+ df_cache_get_simple('', function() {return array_column($this->req('ideal/issuers/'), 'name', 'id');})
	;});}

	/**
	 * 2017-02-26
	 * @used-by \Dfe\GingerPaymentsBase\Method::getConfigPaymentAction()
	 */
	function lastResponse():string {return $this->_lastResponse;}

	/**
	 * 2017-03-09
	 * 1) https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#requesting-the-order-status
	 * 2) $id is the order ID.
	 * @used-by \Dfe\GingerPaymentsBase\W\Handler::strategyC()
	 * @return array(string => mixed)
	 */
	function orderGet(string $id):array {return $this->req("orders/$id");}

	/**
	 * 2017-02-27
	 * @used-by \Dfe\GingerPaymentsBase\Method::getConfigPaymentAction()
	 * @param array(string => mixed) $o
	 * @return array(string => mixed)
	 */
	function orderPost(array $o):array {return $this->req('orders/', 'post', [
		'body' => json_encode($o), 'headers' => ['Content-Type' => 'application/json']
	]);}

	/**
	 * 2017-03-09
	 * 2022-12-28 @deprecated It is unused.
	 * @param array(string => mixed) $o
	 * @return array(string => mixed)
	 */
	function orderUpdate(array $o):array {return $this->putOrder($o);}

	/**
	 * 2017-03-01
	 * 1) https://www.gingerpayments.com/docs#_merchants
	 * 2) [Ginger Payments] Why does a «GET merchants/self/projects/self/» request
	 * lead to the «You don't have the permission to access the requested resource» response?
	 * https://mage2.pro/t/3457
	 * 3) [Kassa Compleet] The «merchants/» API part is undocumented: https://mage2.pro/t/3459
	 * 4) [Kassa Compleet] An example of a response to «GET merchants/self/projects/self/»
	 * https://mage2.pro/t/3458
	 * @used-by \Dfe\GingerPaymentsBase\Test\GetMerchant::t01()
	 */
	function products(string $mId = 'self', string $pId = 'self'):array {return $this->req(
		"merchants/{$mId}/projects/{$pId}/"
	);}

	/**
	 * 2017-03-09
	 * @param array(string => mixed) $o
	 * @return array(string => mixed)
	 */
	private function putOrder(array $o):array {return $this->req("orders/{$o['id']}/", 'put', [
		'timeout' => 10, 'json' => $o
	]);}

	/** @noinspection PhpInconsistentReturnPointsInspection */
	/**
	 * 2017-02-26
	 * @param array(string => mixed) $params
	 * @return array(string => mixed)
	 * @throws DFE
	 */
	private function req(string $uri, string $method = 'get', array $params = []):array {
		try {
			/** @var array(string => mixed) $r */
			$r = df_json_decode((string)$this->_guzzle->request($method, $uri, $params)->getBody());
			# 2017-02-26
			# Намеренно выполняем двойное кодирование-декодирование,
			# чтобы привести форматирование JSON к удобному для нас виду.
			$this->_lastResponse = df_json_encode($r);
			return $r;
		}
		catch (ERequest $e) {
			df_error((string)$e->getResponse()->getBody());
		}
	}

	/**
	 * 2017-02-26   
	 * @used-by self::__construct()
	 * @used-by self::req()
	 * @var HttpClient
	 */
	private $_guzzle;

	/**
	 * 2017-02-26
	 * @used-by self::lastResponse()
	 * @used-by self::req()
	 * @var string
	 */
	private $_lastResponse;
}