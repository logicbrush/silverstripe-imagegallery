<% if $GalleryPage && $Images %>
<div class="gallery-widget">
	<div class="image-gallery" itemscope itemtype="http://schema.org/ImageGallery">
		<% loop $Images %>
		<figure class="item" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" data-index="$Pos(0)">
			<a href="$FitMax(2000,2000).URL" itemprop="contentUrl" data-width="$FitMax(1000,1000).Width" data-height="$FitMax(1000,1000).Height" data-index="$Pos(0)" aria-label="$Title.XML">
				<img src="{$FocusFill(640,640).URL}" itemprop="thumbnail" alt="$Title.XML" />
			</a>
		</figure>
		<% end_loop %>
	</div>

	<p><a href="$GalleryPage.Link">see all</a></p>

</div>
<% end_if %>