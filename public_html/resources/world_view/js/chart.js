$(function() {
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
			url: $("#world").attr("data-url"),
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
						return(this.popup && this.popup.remove());
					});
			}
		});
	}

	function drawUserGraph(){
		var jsonData = $.ajax({
			type: 'POST',
			url: $("#user").attr("data-url"),
			data: {lookup: y},
			dataType:"json",
			success: function(data){
				if(data.user.x.length > 0 && data.user.y.length > 0) {
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
							return(this.popup && this.popup.remove());
						});
				}
			}
		});
	}
});
