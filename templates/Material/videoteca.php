<div class="w3-container">

	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-brands fa-youtube"></i> Videos y documentales para consulta</h4>
	</div>

	<div class="w3-container">
		<div class="w3-col s12 l3">
			<h5 class="w3-margin-top w3-text-blue-gray">Canal oficial</h5>
			
			<?= $this->Html->script('https://apis.google.com/js/platform.js', ['block' => 'script'])?>
			<div class="w3-margin">
				<div class="g-ytsubscribe" data-channelid="UCDokoFcraNxdN2ED8shN27A" data-layout="full" data-count="default"></div>
			</div>
			
			<ul class="w3-ul">
			<?php foreach($videos as $video){ ?>
				<li class=""><i class="fas fa-video"></i> <a href="#" onclick="embedVideo('<?= $video->id->videoId ?>')"><?php echo $video->snippet->title ?></a></li>
			<?php } ?>
			</ul>
			<h5 class="w3-margin-top w3-text-blue-gray">Material extra</h5>
			<ul class="w3-ul">
				<li class=""><i class="fas fa-video"></i> <a href="#" onclick="embedVideo('TGNKU_KS4-Y')">La etapa lítica en México</a></li>
				<li class=""><i class="fas fa-video"></i> <a href="#" onclick="embedVideo('eewAlcK02so')">La etapa lítica y sus períodos</a></li>
			</ul>
			<p>&nbsp;</p>
		</div>
		<div class="w3-col s12 l9">
			<div class="w3-margin-top w3-light-gray videoWrapper" style="">
				<i class="fa-brands fa-youtube w3-text-white w3-jumbo w3-center" style="padding:166px;margin:auto;display:block;" id="YTicon"></i>
				<iframe id="videoPlayer" width="100%" height="0" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>
<style>
.videoWrapper {
	/*min-height:120px;*/
	/* falls back to 16/9, but otherwise uses ratio from HTML (div.attr.style = --aspect-ratio:3/4;)*/
	/*padding-bottom: calc(var(--aspect-ratio, .5625) * 100%); */
}
@media only screen and (max-width:640px) { #YTicon{padding:48px !important;}}
</style>
<script type="text/javascript">
	function embedVideo(videoID){
		$("#videoPlayer").css('height', '405px');
		$("#YTicon").hide();
		$("#videoPlayer").attr('src', 'https://www.youtube.com/embed/' + videoID);
		return true;
	}
</script>
