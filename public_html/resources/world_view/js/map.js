$(function() {
	var rsr = Raphael('rsr', '500', '500');
	var familyName = $("#rsr").attr("data-family-name");

	rsr.image($("#rsr").attr("data-map-url") + $('#map').val(), 0, 0, 500, 500);
	draw_lmus();

	$('#change_map').on('click', function(){
		var newImage = $("#rsr").attr("data-map-url") + $('#map').val();
		rsr.image(newImage, 0,0,500,500);
		if ( $('#map').val()=="world_map.png" )
		{
		draw_lmus();
		}
	});

	function draw_lmus(){
		var url = $("#rsr").attr("data-lmu-url");
		var paths = [];

		$.ajax({
			type: 'POST',
			url: $("#rsr").attr("data-paths-url"),
			dataType:"json",
			success: function(data){
				for(var i in data){
					var path = "m";
					for(var j in data[i]){
						path = path + " " + data[i][j].x + ", " + data[i][j].y;
					}
					path = path + " z";

					var filler = (familyName == data[i].owner) ? '#00FF00' : '#00FFFF';

					paths[i] = rsr.path(path).attr({
						id: i,
						'stroke-width': '0',
						fill: filler,
						opacity: '.2',
						title: 'LMU ' + i + ' Owner: ' + data[i].owner
					});

					paths[i].data("owner", data[i].owner);

					(function(i, filler) {
						paths[i].mouseover(function() {
							this.toFront();
							this.attr({
								cursor: 'pointer'
							});
							this.animate({
								opacity: '1',
								transform: "s1.4"
							}, 200);
						});

						paths[i].mouseout(function() {
							this.animate({
								opacity: '.2',
								transform: "s1"
							}, 200);
						});

						paths[i].click(function() {
							if(familyName == paths[i].data("owner")){
								window.location = url + "/" + i;
							}
							else{
								alert("LMU " + i + " Owner: " + paths[i].data("owner"));
							}
						});
					})(i, filler);
				}
			}
		});
	}
});

