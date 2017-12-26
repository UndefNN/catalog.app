<?php
namespace App\Classes;

use Goutte\Client;

class Parser {

    protected $link;
    protected $attributes;

    /**
     * Конструктор
     *
     * @param string $link
     * @param array $attributes
     *
     * */

    public function __construct( $link = '', $attributes = array() ) {
        $this->link = ( $link !== '' ) ? $link : 'http://www.rusprofile.ru';
        $this->attributes = array_merge( [
            'list' => array (
                'element'   => '//ul[@class="unitlist"]/li//div[@class="u-frame"]',
                'name'      => '//*[@class="und"]',
                'owner'     => '//*[@class="u-ceoname"]',
                'address'   => '//*[@class="u-address"]',
                'link'      => '//a/@href'
            ),
            'company' => array (
                'name'      => '//*[@itemprop="name"]',
                'full_name' => '//*[@itemprop="legalName"]',
                'inn'       => '//*[@itemprop="taxID"]',
                'postal'    => '//*[@itemprop="postalCode"]',
                'region'    => '//*[@itemprop="addressRegion"]',
                'locality'  => '//*[@itemprop="addressLocality"]',
                'street'    => '//*[@itemprop="streetAddress"]'
            )
        ], $attributes);
    }

    /**
     * Получим список организаций по строке
     *
     * @param string $string
     * @return array|bool
     * */

    public function getListCompanies($string = '') {

        if ($string == '') {
            return false;
        }

        $attributes = $this->attributes['list'];
        $html = (new Client)->request('get', $this->link . '/search?query=' . $string);
        $companies = array();

        $list = $html->filterXpath($attributes['element']);

        for ( $i = 0; $i < $list->count(); $i ++ ) {
            $companies[] = $this->eachAttributes( $list->eq($i), $attributes, ['element']);
        };

        return $companies;

    }

    /**
     * Данные компании по ссылке
     *
     * @param integer $id
     * @return array
     * */

    public function getCompany( $id ) {

        $html = (new Client)->request('get', $this->link . $id);

        $attributes = $this->attributes['company'];
        $company = $this->eachAttributes($html, $attributes);

        return count($company) > 0 ? $company : [];
    }

    /**
     * Обход массива параметров
     *
     * @param \Symfony\Component\DomCrawler\Crawler $crawler;
     * @param array $attributes
     * @param array $exclude (default: []) Список игнорируемых эллементов
     *
     * @return array
     * */

    private function eachAttributes ( $crawler, $attributes, $exclude = []) {
        $data = array();

        if ( count($exclude) > 0 ) {
            $attributes = array_diff_key( $attributes, array_flip( $exclude ) );
        };

        foreach ( $attributes as $key => $path ) {
            if ( $crawler->filterXpath($path)->count() > 0 ){
                $data[$key] = trim( $crawler->filterXpath($path)->text() );
            }
        };

        return $data;
    }

    /**
     * Парсер основанный на регулярных выражения
     * */
    public function regexGetCompany( $id ) {

      $data = array();    // Массив, сюда будем сохранять данные
      $ch = curl_init();  // Инициализация curl (загрузка страницы)

      // установка URL и других необходимых параметров
      curl_setopt($ch, CURLOPT_URL, $this->link . $id);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $html = curl_exec($ch); // загрузка страницы

      curl_close($ch);  // завершение сеанса и освобождение ресурсов

      // Массив с патернами для обработки параметров
      $paterns = [
          'name'      => '/<(\w+)\s+[^>]*itemprop=["\']name["\']\s?+[^>]*>(.*?)(\s+)?(<.*)?<\/\1>/su',
          'full_name' => '/<(\w+)\s+[^>]*itemprop=["\']legalName["\']\s?+[^>]*>(.*?)<\/\1>/su',
          'inn'       => '/<(\w+)\s+[^>]*itemprop=["\']taxID["\']\s?+[^>]*>(.*?)<\/\1>/su',
          'postal'    => '/<(\w+)\s+[^>]*itemprop=["\']postalCode["\']\s?+[^>]*>(.*?)<\/\1>/su',
          'region'    => '/<(\w+)\s+[^>]*itemprop=["\']addressRegion["\']\s?+[^>]*>(.*?)<\/\1>/su',
          'locality'  => '/<(\w+)\s+[^>]*itemprop=["\']addressLocality["\']\s?+[^>]*>(.*?)<\/\1>/su',
          'street'    => '/<(\w+)\s+[^>]*itemprop=["\']streetAddress["\']\s?+[^>]*>(.*?)<\/\1>/su',
      ];

      if ( $html !== false ) {
        // Оходим массив патернов, и сохраняем значение полей
          foreach ( $paterns as $key => $patern ) {
              preg_match($patern, $html, $matches);
              $data[$key] = isset($matches[2]) ? htmlspecialchars_decode( trim($matches[2]) ) : '';
          }
      }

      return $data;
    }


}
