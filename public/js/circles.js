var SelectedCircles = false;
$("#circlesBtn").click(function(){
if(SelectedCircles == false){
function activeBackbone(){
  $("#circles").find('g.node').each(function(){
    new App.views.Node({el:this});
  });
}

  var w = 900,
    h = 480,
    rx = w / 2,
    m0,
    rotate = 0;

var cluster = d3.layout.cluster()
    .size([360, rx]);

var diagonal = d3.svg.diagonal.radial()
    .projection(function(d) { return [d.y, d.x / 180 * Math.PI]; });

var svg = d3.select("#circles").append("div")
    .style("width", w + "px")
    .style("height", h + "px");

var vis = svg.append("svg:svg")
    .attr("width", w*1.5)
    .attr("height", w*1.5)
  .append("svg:g")
    .attr("transform", "translate(" + w*(0.75) + "," + h*(1.25) + ")");

vis.append("svg:path")
    .attr("class", "arc")
    .attr("d", d3.svg.arc().innerRadius(rx - 120).outerRadius(rx).startAngle(0).endAngle(2 * Math.PI))
    .on("mousedown", mousedown);

d3.json("js/flare.json", function(json) {
  
    var nodes = cluster.nodes(json);

    var link = vis.selectAll("path.link")
        .data(cluster.links(nodes))
      .enter().append("svg:path")
        .attr("class", "link")
        .attr("d", diagonal);

    var node = vis.selectAll("g.node")
        .data(nodes)
      .enter().append("svg:g")
        .attr("class", "node")
        .attr("transform", function(d) { return "rotate(" + (d.x - 90) + ")translate(" + d.y + ")"; })

    node.append("svg:circle")
        .attr("r", 3);

    node.append("svg:text")
        .attr("dx", function(d) { return d.x < 180 ? 8 : -8; })
        .attr("dy", ".31em")
        .attr("text-anchor", function(d) { return d.x < 180 ? "start" : "end"; })
        .attr("transform", function(d) { return d.x < 180 ? null : "rotate(180)"; })
        .text(function(d) { return d.name; });
    activeBackbone();
    
});

d3.select(window)
    .on("mousemove", mousemove)
    .on("mouseup", mouseup);

function mouse(e) {
  return [e.pageX - rx, e.pageY - rx];
}

function mousedown() {
  m0 = mouse(d3.event);
  d3.event.preventDefault();
}

function mousemove() {
  if (m0) {
    var m1 = mouse(d3.event),
        dm = Math.atan2(cross(m0, m1), dot(m0, m1)) * 180 / Math.PI,
        tx = "translate3d(0," + (rx - rx) + "px,0)rotate3d(0,0,0," + dm + "deg)translate3d(0," + (rx - rx) + "px,0)";
    svg
        .style("-moz-transform", tx)
        .style("-ms-transform", tx)
        .style("-webkit-transform", tx);
  }
}

function mouseup() {
  if (m0) {
    var m1 = mouse(d3.event),
        dm = Math.atan2(cross(m0, m1), dot(m0, m1)) * 180 / Math.PI,
        tx = "rotate3d(0,0,0,0deg)";

    rotate += dm;
    if (rotate > 360) rotate -= 360;
    else if (rotate < 0) rotate += 360;
    m0 = null;

    svg
        .style("-moz-transform", tx)
        .style("-ms-transform", tx)
        .style("-webkit-transform", tx);

    vis
        .attr("transform", "translate(" + rx + "," + rx + ")rotate(" + rotate + ")")
      .selectAll("g.node text")
        .attr("dx", function(d) { return (d.x + rotate) % 360 < 180 ? 8 : -8; })
        .attr("text-anchor", function(d) { return (d.x + rotate) % 360 < 180 ? "start" : "end"; })
        .attr("transform", function(d) { return (d.x + rotate) % 360 < 180 ? null : "rotate(180)"; });
  }
}

function cross(a, b) {
  return a[0] * b[1] - a[1] * b[0];
}

function dot(a, b) {
  return a[0] * b[0] + a[1] * b[1];
}


SelectedCircles = true;
  }
});


