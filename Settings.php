<?php
namespace Df\GingerPaymentsBase;
use Assert\Assertion as Guard;
use Df\GingerPaymentsBase\Source\Option as OS;
use Df\Payment\Settings\Options as O;
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
	 * @param null|string|int|S|Store $s [optional]
	 * @return API
	 */
	final function api($s = null) {return dfc($this, function($s) {
		/** @var string $apiKey */
		$apiKey = $this->privateKey($s);
		Guard::uuid(self::apiKeyToUuid($apiKey), "API key is invalid: «{$apiKey}».");
        return new API($this, new HttpClient([
			'auth' => [$apiKey, '']
			,'base_uri' => "https://api.{$this->apiDomain()}/v1/"
			,'headers' => ['User-Agent' => df_cc_s(
				'Mage2.PRO', $this->titleB(), df_package_version($this)
			)] + df_headers()
		]));
	}, [$s]);}

	/**
	 * 2017-03-03
	 * @used-by \Df\GingerPaymentsBase\ConfigProvider::config()
	 * @return O
	 */
	final function options() {
		/** @var OS $os */
		$os = df_sc(df_con_heir($this, OS::class), OS::class);
		return $this->test() ? $os->optionsTest() : $this->_options($os)->o();
	}

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