<?php
namespace Df\GingerPaymentsBase;
use Assert\Assertion as Guard;
use GingerPayments\Payment\Client as API;
use GuzzleHttp\Client as HttpClient;
use Magento\Framework\App\ScopeInterface as S;
use Magento\Store\Model\Store;
/**
 * 2017-02-25
 * @method static Settings s()
 * @see \Dfe\GingerPayments\Settings
 * @see \Dfe\KassaCompleet\Settings
 */
abstract class Settings extends \Df\Payment\Settings implements \GingerPayments\Payment\IProduct {
	/**
	 * 2017-02-26
	 * @see \Dfe\GingerPayments\Settings::apiDomain()
	 * @see \Dfe\KassaCompleet\Settings::apiDomain()
	 * @used-by api()
	 * @return string
	 */
	abstract protected function apiDomain();

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
		$apiKey = $this->privateKey($s);
		Guard::uuid(self::apiKeyToUuid($apiKey), "API key is invalid: «{$apiKey}».");
        return new API($this, new HttpClient([
			'auth' => [$apiKey, '']
			,'base_url' => "https://api.{$this->apiDomain()}/v1/"
			,'headers' => df_headers(['User-Agent' => df_cc_s(
				'Mage2.PRO', $this->titleB(), df_package_version($this)
			)])
		]));
	}, [!is_null($test) ? $test : $this->test(), $s]);}

    /**
     * 2017-02-26
	 * @used-by api()
     * @param string $apiKey
     * @return string UUID
     */
    private static function apiKeyToUuid($apiKey) {return
		preg_replace('/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/', '$1-$2-$3-$4-$5', $apiKey)
	;}
}