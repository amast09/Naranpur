<script src="<?php echo base_url("/resources/base/js/raphael.js");?>"></script>
<script src="<?php echo base_url("/resources/world_view/js/g.raphael-min.js");?>"></script>
<script src="<?php echo base_url("/resources/world_view/js/g.line.js");?>"></script>

<div class="row-fluid" style="text-align:right;">
	<div class="span9">
		<div id='world'></div>
		<div id="worldBtns" class="btn-group" data-toggle="buttons-radio">
			<button type="button" data-lookup="P" class="btn btn-primary active">Rainfall</button>
			<button type="button" data-lookup="pop" class="btn btn-primary">Population</button>
			<button type="button" data-lookup="delH" class="btn btn-primary">Depth to Water</button>
			<button type="button" data-lookup="percentCropped" class="btn btn-primary">Percent Crop</button>
			<button type="button" data-lookup="avgHealth" class="btn btn-primary">Health</button>
		</div>
	</div>

	<div class="span3" style="text-align:center;">
		<div style="color:#F00;"> Entire World </div>
	</div>
</div>

<div class="row-fluid" style="text-align:right;">
	<div class="span9">
	<div id='user'></div>

	<div id="userBtns" class="btn-group" data-toggle="buttons-radio">
		<button type="button" data-lookup="money" class="btn btn-primary active">Money</button>
		<button type="button" data-lookup="grain" class="btn btn-primary">Grain</button>
		<button type="button" data-lookup="straw" class="btn btn-primary">Straw</button>
		<button type="button" data-lookup="milk"  class="btn btn-primary">Milk</button>
		<button type="button" data-lookup="water" class="btn btn-primary">Water</button>
		<button type="button" data-lookup="avgHealth" class="btn btn-primary">Health</button>
		<button type="button" data-lookup="conc" class="btn btn-primary">Contaminants</button>
	</div>
	</div>
	<div class="span3" style="text-align:center;">
		<div style="color:#00FFFF;">Average Family</div>
		<div style="color:#00FF00;">Your Family</div>
	</div>
</div>

<script>
var x = 'P';
var y = 'money';
var world = Raphael('world', '500', '250');
var user = Raphael('user', '500', '250');
drawWorldGraph();
drawUserGraph();

$("#worldBtns .btn").click(function() {
	x = $(this).data('lookup');
	drawWorldGraph();
});

$("#userBtns .btn").click(function() {
	y = $(this).data('lookup');
	drawUserGraph();
});

function drawWorldGraph(){
	var jsonData = $.ajax({
		type: 'POST',
 	  url: "<?=site_url('charts/get_world_data')?>",
		data: {lookup: x},
 		dataType:"json",
		success: function(data){
			world.clear();
			world.text(10, 115, x);
			world.text(270, 250, 'Week');
			world.linechart(70, 0, 390, 230, data.x, data.y, {
				smooth: false,
				gutter: 8,
				colors: ['#F00'],
				symbol: 'circle',
				width: 1,
				shade: 'true',
				axisystep: '10',
				axisxstep: 26,
				axis: '0 0 1 1'
			}).hoverColumn(
				function () {
					this.popup = world.set();
					for (var i = 0, ii = this.y.length; i < ii; i++) {
						this.popup.push(world.popup(this.x, this.y[i], this.values[i], 'down').insertBefore(this).attr([{ fill: "#fff" }, { fill: this.symbols[i].attr("fill") }]));
       		}

    		},
				function () {
        	this.popup && this.popup.remove();
        });
		}
	});
}

function drawUserGraph(){
	var jsonData = $.ajax({
		type: 'POST',
 	  url: "<?=site_url('charts/get_user_data')?>",
		data: {lookup: y},
 		dataType:"json",
		success: function(data){
			user.clear();
			user.text(15, 115, y);
			user.text(270, 250, 'Week');
			user.linechart(70, 0, 390, 230, data['user'].x, [data['user'].y, data['avg'].y], {
				smooth: false,
				gutter: 8,
				colors: ['#00FF00', '#00FFFF'],
				symbol: ['circle', 'circle'],
				width: 1,
				shade: 'true',
				axisystep: '10',
				axisxstep: 26,
				axis: '0 0 1 1'
			}).hoverColumn(
				function () {
					this.popup = user.set();
					this.popup.push(user.popup(this.x, this.y[0], this.values[0], 'left').insertBefore(this).attr([{ fill: "#fff" }, { fill: this.symbols[0].attr("fill") }]));
					this.popup.push(user.popup(this.x, this.y[1], this.values[1], 'right').insertBefore(this).attr([{ fill: "#fff" }, { fill: this.symbols[1].attr("fill") }]));
    		},
				function () {
        	this.popup && this.popup.remove();
        });
		}
	});
}
</script>
