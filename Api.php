<?php
namespace Df\GingerPaymentsBase;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException as ERequest;
use RuntimeException as E;
final class Api {
	/**
	 * 2017-02-25
	 * @used-by \Df\GingerPaymentsBase\Settings::api()
	 * @param HttpClient $httpClient
	 */
	function __construct(HttpClient $httpClient) {$this->_guzzle = $httpClient;}

	/**
	 * 2017-03-04
	 * @used-by \Df\GingerPaymentsBase\ConfigProvider::config()
	 * @used-by \Df\GingerPaymentsBase\T\GetIdealBanks::t01()
	 * @return array(string => string)
	 */
	function idealBanks() {return array_column($this->req('ideal/issuers/'), 'name', 'id');}

	/**
	 * Get a single order.
	 *
	 * @param string $id The order ID.
	 * @return array(string => mixed)
	 */
	function getOrder($id) {return $this->req("orders/$id");}

	/**
	 * Check if account is in test mode.
	 *
	 * @return bool
	 */
	function isInTestMode() {return $this->isTestMode($this->req('merchants/self/projects/self/'));}

	/**
	 * 2017-02-26
	 * @return string
	 */
	function lastResponse() {return $this->_lastResponse;}

	/**
	 * 2017-02-27
	 * @used-by \Df\GingerPaymentsBase\Method::getConfigPaymentAction()
	 * @param array(string => mixed) $o
	 * @return array(string => mixed)
	 */
	function postOrder(array $o) {return $this->req('orders/', 'post', [
		'body' => json_encode($o)
		,'headers' => ['Content-Type' => 'application/json']
		,'timeout' => 10
	]);}

	/**
	 * Update an existing order.
	 *
	 * @param array(string => mixed) $o
	 * @return array(string => mixed)
	 */
	function updateOrder(array $o) {return $this->putOrder($o);}

	/**
	 * Process test-mode API response.
	 *
	 * @param array $projectDetails
	 * @return bool
	 */
	private function isTestMode($projectDetails)
	{
		if (!array_key_exists('status', $projectDetails)) {
			return false;
		}

		return ($projectDetails['status'] == 'active-testing');
	}

	/**
	 * Process the API response with allowed payment methods.
	 *
	 * @param array $details
	 * @return array
	 */
	private function processProducts($details)
	{
		$result = array();

		if (!array_key_exists('permissions', $details)) {
			return $result;
		}

		if (array_key_exists('status', $details)
			&& $details['status'] == 'active-testing') {
			return array('ideal');
		}

		$products_to_check = array(
			'ideal' => 'ideal',
			'bank-transfer' => 'banktransfer',
			'bancontact' => 'bancontact',
			'cash-on-delivery' => 'cashondelivery',
			'credit-card' => 'creditcard',
		);

		foreach ($products_to_check as $permission_id => $id) {
			if (array_key_exists('/payment-methods/'.$permission_id.'/', $details['permissions']) &&
				array_key_exists('POST', $details['permissions']['/payment-methods/'.$permission_id.'/']) &&
				$details['permissions']['/payment-methods/'.$permission_id.'/']['POST']
			) {
				$result[] = $id;
			}
		}

		return $result;
	}

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
	function products($mId = 'self', $pId = 'self') {return $this->processProducts(
		$this->req("merchants/{$mId}/projects/{$pId}/")
	);}

	/**
	 * PUT order data to Ginger API.
	 *
	 * @param array(string => mixed) $o
	 * @return array(string => mixed)
	 */
	private function putOrder(array $o) {return $this->req(
		"orders/{$o['id']}/", 'put', ['timeout' => 10, 'json' => $o])
	;}

	/**
	 * 2017-02-26
	 * @param string $uri
	 * @param string $method [optional]
	 * @param array(string => mixed) $params
	 * @param mixed|null $onError [optional]
	 * @return array(string => mixed)
	 */
	private function req($uri, $method = 'get', $params = [], $onError = null) {
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
			if (!is_null($onError)) {
				return $onError;
			}
			if (404 == $e->getCode()) {
				throw new E('An object with he ID given is absent.', 404, $e);
			}
			/** @var string $message */
			$message = "An error occurred: {$e->getMessage()}" . (string)$e->getResponse()->getBody();
			throw new E($message, $e->getCode(), $e);
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