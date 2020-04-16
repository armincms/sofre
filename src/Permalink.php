<?php 
namespace Armincms\Sofre;

use Core\HttpSite\Concerns\HasPermalink;
 
trait Permalink
{
	use HasPermalink;  

	static public function bootHasMultilingualPermalink()
	{
		self::saved(function($model) {
			$model->getTranslationModel()::saved(function($translate) use ($model) {
				if($model->translations->count() === 0 && $model::autoLink()) { 
					$model->load('translations')->setPermalink();
				}
			});
		});
	}

    public function setPermalink(string $column = 'url', bool $encode = true) 
    {      
		$translations = $this->translations;  

        foreach ($translations as $translate) { 
            $previous = array_get($translate, "attributes.{$column}");

            $this->setRelation('translations', collect([$translate])); 

            $url = $this->buildUrl($this->component()->route()); 

	    	$this->setAttribute(
	    		"{$translate->language}::$column",  $encode ? $this->encode($url) : $url
	    	);

	    	$translate->save();

	    	$this->modificationEvent($url, $previous);  
        }

        $this->setRelation('translations', $translations);   
    }    

	public function url(bool $decode = true, string $locale = null)
	{     
		if($relativeUrl  = $this->relativeUrl($decode, $locale)) { 
			return $this->site()->url($relativeUrl, $this->ensureLocale($locale)); 
		}  
	} 

	public function relativeUrl(bool $decode = true, string $locale = null)
	{ 
		if($url = $this->trans('url', $this->ensureLocale($locale))) {
			return $decode ? $this->decode($url) : $url;
		} 		
	}

	public function getUrlAttribute()
	{
		return $this->url();
	}

	public function getRelativeUrlAttribute()
	{
		return $this->relativeUrl();
	}
}
