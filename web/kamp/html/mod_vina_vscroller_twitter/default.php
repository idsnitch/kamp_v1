<?php
/*
# ------------------------------------------------------------------------
# Vina Vertical Scroller for Tweeter for Joomla 3
# ------------------------------------------------------------------------
# Copyright(C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://vinagecko.com
# Forum:    http://vinagecko.com/forum/
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.modal');

$doc = JFactory::getDocument();
$doc->addScript('modules/mod_vina_vscroller_twitter/assets/js/jquery.easing.min.js', 'text/javascript');
$doc->addScript('modules/mod_vina_vscroller_twitter/assets/js/jquery.easy-ticker.js', 'text/javascript');
$doc->addStyleSheet('modules/mod_vina_vscroller_twitter/assets/css/style.css');

// Add styles
$stylebgImage = ($bgImage != '') ? "background: url({$bgImage}) repeat scroll 0 0;" : '';
$stylebgImage .= ($isBgColor) ? "background-color: {$bgColor};" : '';
$styleisItemBgColor = ($isItemBgColor) ? "background-color: {$itemBgColor};" : "";
//$styleshowAvatar = ($showAvatar) ? "avatarWidth: {$avatarWidth};" : "";
$padding_left = $showAvatar ? 'padding-left:' . ($avatarWidth + 20) . 'px;' : '';

$style = '#vina-vscoller-twitter'.$module->id .'{'
        . 'max-width:'.$moduleWidth.';'
        . 'padding:'.$modulePadding.';'
		. $stylebgImage 
        . '}'
		. '#vina-vscoller-twitter'.$module->id .' .vina-item {'
		. 'padding:' .$itemPadding .';'
		. 'color:' . $itemTextColor . ';'
		. 'border-bottom: solid 1px' . $bgColor . ';'
		. $styleisItemBgColor
		. $padding_left
		. '}'
		. '#vina-vscoller-twitter'.$module->id .' .vina-item a{'
		. 'color:' . $itemLinkColor . ';'
		. '}'
		. '#vina-vscoller-twitter'.$module->id .' .header-block {'
		. 'color:' .$headerColor . ';'
		. 'margin-bottom: ' . $modulePadding . ';'
		. '}'
		. '#vina-vscoller-twitter'.$module->id .' .follow-us a {'
		. 'color:' . $headerColor . ';'
		. '}'
		. '#vina-vscoller-twitter'.$module->id .' .vina-item .avatar {'
		. 'left: -' . ($avatarWidth + 10) . 'px;'
		. '}'; 
$doc->addStyleDeclaration($style);
?>
<div id="vina-vscoller-twitter<?php echo $module->id; ?>" class="vina-vscoller-twitter">

<!-- Header Buttons Block -->
	<?php if($headerBlock) : ?>
	<div class="header-block">
		<div class="row-fluid">
			<?php if(!empty($headerText)) : ?>
			<div class="span<?php echo ($controlButtons && $enableScroller) ? 9 : 12; ?>">
				<h3><span class="title"><?php echo $headerText; ?></span></h3>
			</div>
			<?php endif; ?>
			
			<?php if($controlButtons && $enableScroller) : ?>
			<div class="span<?php echo empty($headerText) ? 12 : 3; ?>">
				<div class="control-block pull-right">
					<span class="up">UP</span>
					<span class="toggle">TOGGLE</span>
					<span class="down">DOWN</span>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>

<!-- Items Block -->	
	<div class="vina-items-wrapper">
		<div class="vina-items">
			<?php 
				foreach($data as $key => $value) :
					$displayName = $value['user']['name'];
					$screenName	 = $value['user']['screen_name'];
					$text 		 = $value['text'];
					$avatar 	 = $value['user']['profile_image_url'];
					$created 	 = $value['created_at'];
					$source  	 = $value['source'];
					$idStr		 = $value['id_str'];
					$permalink	 = "http://twitter.com/" . $screenName . "/status/" . $idStr;
					$profile	 = "http://twitter.com/" . $screenName;
			?>
			<div class="vina-item">
				<!-- Header Block -->
				<div class="vina-header">										
					<!-- Tweet Time -->
					<?php if($tweetTime) : ?>
					<a href="<?php echo $permalink; ?>" class="permalink" <?php echo $target; ?>>
						<?php //echo  JText::_('ABOUT') . '&nbsp;' . $helper->timeago($created) . '&nbsp;' . JText::_('AGO'); ?>
						<?php echo JHtml::_('date',$created, "d M");?>
					</a>
					<?php endif; ?>
				
					<!-- Author Block -->
					<div class="author">
						<!-- Avatar Block -->
						<?php if($showAvatar) : ?>
						<a href="<?php echo $profile; ?>" class="profile" <?php echo $target; ?>>
							<img class="avatar" src="<?php echo $avatar; ?>" alt="<?php echo $displayName; ?>" title="<?php echo $displayName; ?>" width="<?php echo $avatarWidth; ?>" height="<?php echo $avatarWidth; ?>" />
						</a>
						<?php endif; ?>
						
						<?php if($showUsername) : ?>
						<a href="<?php //echo $profile; ?>" class="profile" <?php //echo $target; ?>>
							<span class="full-name"><?php echo $displayName; ?></span>
						</a>
						<a href="<?php echo $profile; ?>" class="nick-name" <?php echo $target; ?>>
							<span class="nick-name">@<?php echo $screenName; ?></span>
						</a>
						<?php endif; ?>
					</div>
				</div>				
				
				<!-- Entry Block -->
				<div class="entry"><?php echo $helper->prepareTweet($text); ?></div>
				
				
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	
	<!-- Follow Us -->
	<?php if($followUs) : ?>
	<div class="follow-us">
		<a class="follow-me" <?php echo $target ?> href="http://twitter.com/<?php echo $username; ?>">
			<?php echo JTEXT::_('VINA_VSCROLLER_TWITTER_FOLLOW_LINK') . $username . JTEXT::_('VINA_VSCROLLER_TWITTER_ON_TWITTER'); ?>
		</a>
	</div>
	<?php endif; ?>
</div>
<?php if($enableScroller) : ?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#vina-vscoller-twitter<?php echo $module->id; ?> .vina-items-wrapper').easyTicker({
		direction: 		'<?php echo $direction?>',
		easing: 		'<?php echo $easing?>',
		speed: 			'<?php echo $speed?>',
		interval: 		<?php echo $interval?>,
		height: 		'<?php echo $moduleHeight; ?>',
		visible: 		<?php echo $visible?>,
		mousePause: 	<?php echo $mousePause?>,
		
		<?php if($controlButtons) : ?>
		controls: {
			up: '#vina-vscoller-twitter<?php echo $module->id; ?> .up',
			down: '#vina-vscoller-twitter<?php echo $module->id; ?> .down',
			toggle: '#vina-vscoller-twitter<?php echo $module->id; ?> .toggle',
			playText: 'Play',
			stopText: 'Stop'
		},
		<?php endif; ?>
	});
});
</script>
<?php endif; ?>