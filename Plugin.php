<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 图片放大插件，放大倍数请自行设置
 * 
 * @package pScaleUp 
 * @author 梁先生呀
 * @version 1.0.1
 * @link http://539go.com
 */
class pScaleUp_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
		Typecho_Plugin::factory('Widget_Archive')->footer = array('pScaleUp_Plugin', 'footer');
	}
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        /** 分类名称 */
        $name = new Typecho_Widget_Helper_Form_Element_Text(
			'size', NULL, '1.6', _t('点击图片后的放大倍数 (默认为1.6)'));
        $form->addInput($name);
		
		$name = new Typecho_Widget_Helper_Form_Element_Text(
			'sHover', NULL, '1', _t('鼠标放上去的变化倍数 (默认为1.0 建议1.005)'));
        $form->addInput($name);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render()
    {
        echo '<span class="message success">'
            . htmlspecialchars(Typecho_Widget::widget('Widget_Options')->plugin('pScaleUp')->word)
            . '</span>';
    }
	public static function footer()
	{
		$code = 
<<<EOL
<style>
	img {
		cursor: pointer;
		transition: -webkit-transform 0.1s ease
	}
	img:hover{
		transform: scale({SHOVER});
		-ms-transform: scale({SHOVER});	/* IE 9 */
		-webkit-transform: scale({SHOVER});	/* Safari 和 Chrome */
		-o-transform: scale({SHOVER});	/* Opera */
		-moz-transform: scale({SHOVER});	/* Firefox */
	}
	img:focus {
		transform: scale({SIZE});
		-ms-transform: scale({SIZE});	/* IE 9 */
		-webkit-transform: scale({SIZE});	/* Safari 和 Chrome */
		-o-transform: scale({SIZE});	/* Opera */
		-moz-transform: scale({SIZE});	/* Firefox */
	}
</style>
<script>
	document.addEventListener('DOMContentLoaded', function(){
		var imgs = document.querySelectorAll('img');
		Array.prototype.forEach.call(imgs, function(el, i) {
			if (el.tabIndex <= 0) el.tabIndex = 100;
		});
	});
</script>
EOL;
        $size = Typecho_Widget::widget('Widget_Options')->plugin('pScaleUp')->size;
        $size = $size <= 0 ? 1.6 : $size;
		$sHover = Typecho_Widget::widget('Widget_Options')->plugin('pScaleUp')->sHover;
        $sHover = $sHover <= 0 ? 1 : $sHover;
		
		$code = str_replace("{SIZE}", $size, $code);
        echo str_replace("{SHOVER}", $sHover, $code);      
	}
}
