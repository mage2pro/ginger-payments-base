<?php
namespace Df\GingerPaymentsBase;
use Assert\Assertion as Guard;
use GingerPayments\Payment\Client as API;
use GingerPayments\Payment\Ginger as G;
use GuzzleHttp\Client as HttpClient;
use Magento\Framework\App\ScopeInterface as S;
use Magento\Store\Model\Store;
/**
 * 2017-02-25
 * @method static Settings s()
 * @see \Dfe\GingerPayments\Settings
 * @see \Dfe\KassaCompleet\Settings
 */
abstract class Settings extends \Df\Payment\Settings {
	/**
	 * 2017-02-26
	 * @used-by account()
	 * @used-by \Dfe\Spryng\Method::api()
	 * @param bool|null $test [optional]
	 * @param null|string|int|S|Store $s [optional]
	 * @return API
	 */
	final public function api($test = null, $s = null) {return dfc($this, function($test, $s) {
		/** @var string $apiKey */
		$apiKey = $this->p(($test ? 'test' : 'live') . 'PrivateKey', $s);
		Guard::uuid(G::apiKeyToUuid($apiKey), "API key is invalid: «{$apiKey}».");
		/** @var string $product */
		$product = $this->product();
        return new API(new HttpClient([
        	'base_url' => [G::getEndpoint($this->product()), ['version' => 'v1']],
			'defaults' => [
				'auth' => [$apiKey, ''], 'headers' => df_headers(['User-Agent' => "Mage2.PRO $product"]),
			]
		]), $product);
	}, [!is_null($test) ? $test : $this->test(), $s]);}

	/**
	 * 2017-02-26
	 * @see \Dfe\GingerPayments\Settings::product()
	 * @see \Dfe\KassaCompleet\Settings::product()
	 * @return string
	 */
	abstract protected function product();
}