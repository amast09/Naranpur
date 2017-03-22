$(function() {
	var $scene = $("#rsr"),
			crops = ($scene.attr("data-planted-crops") === "") ? [] : $.parseJSON($scene.attr("data-planted-crops")),
			images = Array(),
			z = 0,
			x = 0,
			rsr = Raphael('rsr', '1200', '550'),
			background = rsr.image($scene.attr("data-background-image"), 0, 0, 1200, 550),
			hut = rsr.image($scene.attr("data-hut-image"), 270, 300, 170, 100),
			barn = rsr.image($scene.attr("data-barn-image"), 860, 300, 300, 210),
			well = rsr.image($scene.attr("data-well-image"), 500, 350, 100, 65),
			farmer = rsr.image($scene.attr("data-farmer-image"), 600, 380, 167, 170),
			field = rsr.set(),
			cropImageHeight = 18,
			cropImageWidth = 20;

	for(; x < crops.length; x++){
		for(var y = 0; y < crops[x]['land_percentage']; y++){
			images[z] = crops[x]['image'];
			z++;
		}
	}

	for(x = images.length; x < 100; x++) images[x] = "field.png";

	z = 0;
	for(var i = 0; i < 10; i++){
		for(var j = 0; j < 10; j++){
			var image =  $scene.attr("data-crop-base-image") + "/" + images[z];
			field.push(
				rsr.image(image, 30 + cropImageWidth * j, 350 + cropImageHeight * i, cropImageWidth, cropImageHeight)
			);
			z++;
		}
	}

	hut.click(function() {$('#family').modal();});
	barn.click(function() {$('#feed').modal();});
	well.click(function() {$('#water').modal();});
	farmer.click(function() {$('#plant').modal();});
	field.click(function() {$('#cultivate').modal();});

	hut.mouseover(function(){this.attr({cursor: 'pointer'});});
	barn.mouseover(function(){this.attr({cursor: 'pointer'});});
	well.mouseover(function(){this.attr({cursor: 'pointer'});});
	farmer.mouseover(function(){this.attr({cursor: 'pointer'});});
	field.mouseover(function(){this.attr({cursor: 'pointer'});});

});