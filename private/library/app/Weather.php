<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 19/11/16
 * Time: 13:14
 */

namespace app;


use general\Date;
use general\Language;

/**
 * Class WeatherDatas
 * @package app
 * @author Valentin Lacour
 */
class WeatherDatas{
    /**
     * @var string
     */
    public $city;
    /**
     * @var string
     */
    public $country;
    /**
     * @var \general\Date
     */
    public $updated_date;
    /**
     * @var WeatherDayDatas
     */
    public $today;
    /**
     * @var array
     */
    public $days;
}

/**
 * Class WeatherDayDatas
 * @package app
 * @author Valentin Lacour
 */
class WeatherDayDatas{
    /**
     * @var string
     */
    public $icon;
    /**
     * @var string
     */
    public $lbl;
    /**
     * @var \general\Date
     */
    public $date;
    /**
     * @var string
     */
    public $temp;
}

/**
 * Class Weather
 * @package app
 * @author Valentin Lacour
 */
class Weather {

    private $city;
    private $zip_code;
    private $unit;
    private $datas;
    private $APIKey;

    function __construct($city, $zip_code = null,$unit = "C")
    {
        $this->city = $city;
        $this->zip_code = $zip_code;
        $this->unit = $unit;
        $this->APIKey = Config::getWeatherAPIKey();
        if($this->APIKey == "")
            throw new \Exception('Pas de clé pour l\'API OpenWeatherMap',3);
        $this->datas = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/forecast/daily?q=$city,$zip_code&mode=json&cnt=5&units=metric&appid=".$this->APIKey));
    }


    /**
     * Récupére la météo
     * @return WeatherDatas
     * @throws \Exception
     */
    public function getWeather(){
        $datas = $this->datas;
        if(empty($datas))
            throw new \Exception('Erreur lors de la réxupération de la météo',2);
        $response = new WeatherDatas();
        $response->city = $datas->city->name;
        $response->country = $datas->city->country;
        $response->updated_date = new Date('now');
        $response->today = new WeatherDayDatas();
        $response->today->date = new Date('now');
        $response->today->lbl = $this->getName($datas->list[0]->weather[0]->icon);
        $response->today->icon = $this->getIcon($datas->list[0]->weather[0]->icon);
        if($this->unit == "C")
            $response->today->temp = round($datas->list[0]->temp->day).'°C';
        else
            $response->today->temp = round($datas->list[0]->temp->day * 9/5 + 32).'°F';
        for($i = 1; $i<5; $i++)
        {
            $tmp = new WeatherDayDatas();
            try{
                $tmp->date = new Date($datas->list[$i]->dt);
            }catch (\Exception $e){

            }
            $tmp->lbl = $this->getName($datas->list[$i]->weather[0]->icon);
            $tmp->icon = $this->getIcon($datas->list[$i]->weather[0]->icon);
            if($this->unit == "C")
                $tmp->temp = round($datas->list[$i]->temp->day).'°C';
            else
                $tmp->temp = round($datas->list[$i]->temp->day * 9/5 + 32).'°F';
            $response->days[] = $tmp;
        }

        return $response;
    }

    /**
     * Récupére le label de météo
     * @param string $id
     * @return mixed
     */
    private function getName($id)
    {
        $response = "";
        switch ($id) {
            case '01d':
                $response = 'clearSky';
                break;
            case '02d':
                $response = 'fewClouds';
                break;
            case '03d':
                $response = 'scatteredCloud';
                break;
            case '04d':
                $response = 'brokenClouds';
                break;
            case '09d':
                $response = 'showerRain';
                break;
            case '10d':
                $response = 'rain';
                break;
            case '11d':
                $response = 'thunderstorm';
                break;
            case '13d':
                $response = 'snow';
                break;
            case '50d':
                $response = 'mist';
                break;
        }
        return Language::get_weather_texts()[$response];

    }

    /**
     * Récupére l'identifiant de l'icone  météo
     * @param string $id
     * @return string
     */
    private function getIcon($id)
    {
        $response = "";
        switch ($id) {
            case '01d':
                $response = 'clear-day';
                break;
            case '02d':
                $response = 'partly-cloudy-day';
                break;
            case '03d':
                $response = 'partly-cloudy-day';
                break;
            case '04d':
                $response = 'cloudy';
                break;
            case '09d':
                $response = 'sleet';
                break;
            case '10d':
                $response = 'rain';
                break;
            case '11d':
                $response = 'rain';
                break;
            case '13d':
                $response = 'snow';
                break;
            case '50d':
                $response = 'fog';
                break;
        }
        return $response;

    }

} 