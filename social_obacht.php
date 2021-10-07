<?php
// no direct access
defined( '_JEXEC' ) or die;

class plgSystemSocial_Obacht extends JPlugin
{
	/**
	 * Load the language file on instantiation. Note this is only available in Joomla 3.1 and higher.
	 * If you want to support 3.0 series you must override the constructor
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;
	protected $app;
	/**
	 * Plugin method with the same name as the event will be called automatically.
	 */
	 function onBeforeCompileHead()
	 {
		/*
		 * Plugin code goes here.
		 * You can access database and application objects and parameters via $this->db,
		 * $this->app and $this->params respectively
		 */
       
		if($this->app->isClient('site'))
		{
			$doc=$this->app->getDocument();

			if($this->app->input->getCmd('view', '') == 'article')
			{	
			
				$id=$this->app->input->getInt('id');
				$article = JTable::getInstance("content");
				$article->load($id);

				if(!in_array($article->catid,$this->params->get("og_content_categories")))
				{
					$doc->addCustomTag('<meta property="og:type" content="article">');
					$doc->addCustomTag('<meta property="og:title" content="'.$doc->getTitle().'">');
					if(strlen($article->introtext) < 10)
					{
						$doc->addCustomTag('<meta property="og:description" content="'.$this->params->get("og_desc_default").'">');
					}else
					{
						$doc->addCustomTag('<meta property="og:description" content="'.substr(strip_tags($article->introtext),0,$this->params->get("og_desc_length")).'">');
					}
					
					$doc->addCustomTag('<meta property="og:url" content="'.$doc->getBase().'">');
					$doc->addCustomTag('<meta property="og:site_name" content="'.$this->app->getTemplate(true)->params->get("firmName").'">');
					if(json_decode($article->images)->image_intro){
					$doc->addCustomTag('<meta property="og:image" content="'.JURI::base(true).'/'.json_decode($article->images)->image_intro.'">');
					}
					else{
						$doc->addCustomTag('<meta property="og:image" content="'.JURI::base(true).'/'.$this->params->get("og_image_default").'">');
					}
				}
				else{
					$doc->addCustomTag('<meta property="og:type" content="website">');
					$doc->addCustomTag('<meta property="og:title" content="'.$this->params->get("og_title_default").'">');
					if($doc->description)
					{
					$doc->addCustomTag('<meta property="og:description" content="'.substr(strip_tags($doc->description),0,$this->params->get("og_desc_length")).'">');
					}
					else{
					$doc->addCustomTag('<meta property="og:description" content="'.$this->params->get("og_desc_default").'">');
					}
					$doc->addCustomTag('<meta property="og:url" content="'.$this->params->get("og_url_default").'">');
					$doc->addCustomTag('<meta property="og:site_name" content="'.$this->app->getTemplate(true)->params->get("firmName").'">');
					$doc->addCustomTag('<meta property="og:image" content="'.JURI::base(true).'/'.$this->params->get("og_image_default").'">');
				}

			}
			elseif($this->app->input->getCmd('view', '') == 'featured')
			{
				$doc->addCustomTag('<meta property="og:type" content="website">');
				$doc->addCustomTag('<meta property="og:title" content="'.$this->params->get("og_title_default").'">');
				$doc->addCustomTag('<meta property="og:description" content="'.$this->params->get("og_desc_default").'">');
				$doc->addCustomTag('<meta property="og:url" content="'.$this->params->get("og_url_default").'">');
				$doc->addCustomTag('<meta property="og:site_name" content="'.$this->app->getTemplate(true)->params->get("firmName").'">');
				$doc->addCustomTag('<meta property="og:image" content="'.JURI::base(true).'/'.$this->params->get("og_image_default").'">');
			}
			else
			{
				$doc->addCustomTag('<meta property="og:type" content="website">');
				$doc->addCustomTag('<meta property="og:title" content="'.$this->params->get("og_title_default").'">');

				if($doc->description)
				{
					$doc->addCustomTag('<meta property="og:description" content="'.substr(strip_tags($doc->description),0,$this->params->get("og_desc_length")).'">');
				}
				else{
					$doc->addCustomTag('<meta property="og:description" content="'.$this->params->get("og_desc_default").'">');
				}
				
				$doc->addCustomTag('<meta property="og:url" content="'.$doc->getBase().'">');
				$doc->addCustomTag('<meta property="og:site_name" content="'.$this->app->getTemplate(true)->params->get("firmName").'">');
				$doc->addCustomTag('<meta property="og:image" content="'.JURI::base(true).'/'.$this->params->get("og_image_default").'">');

			}



		}


		return true;
	}
}
?>