/*A temporary pie chart code*/

/**
 * Created by raviteja ganireddy on 24/03/2017.
 */
 
 //Cutoff constants
 var AKI_CUTOFF = 35;
 var ICU_CUTOFF = 35;
 var MV_CUTOFF = 13;
 var CV_CUTOFF = 7;
 var SEP_CUTOFF = 6;
 var MORT_CUTOFF = 5;
 //----------------
 
function wordwrap(text) {
    var lines=text.split(" ")
    return lines
}
var dataset = [];

function generatechart(labels) {
    var colors = ['Abulia', 'Blue', 'Betelgeuse', 'Cantaloupe', 'Abulia', 'Betelgeuse','Cantaloupe'];
    for(i=0;i<labels.length;i++){
    	dataset.push({});
    	dataset[i].id = i;
        dataset[i].label = labels[i][0].label;
        dataset[i].radius = 70;
        dataset[i].start = 1 + 100 / labels.length * i;
        dataset[i].end = 100/labels.length * (i+1) - 1;
        dataset[i].color = colors[i];
        dataset[i].pred = 50;
        console.log(dataset[i].id + " = " + labels[i][0].label);
    /*
        dataset.push({});
    	dataset[i].id = i;
        dataset[i].label = labels[i];
        dataset[i].radius = 70;
        dataset[i].start = 1 + 100 / labels.length * i;
        dataset[i].end = 100/labels.length * (i+1) - 1;
        dataset[i].color = colors[i];
        dataset[i].pred = 50;
        console.log(dataset[i].id + " = " + dataset[i].label);
        */
    }

    
    var chartContainer = document.getElementById("chart");
    var bodyRect = document.body.getBoundingClientRect();
    var chartRect = chartContainer.getBoundingClientRect();
    var offset = (chartRect.top - bodyRect.top);
    
    
    var innerradius = 10;
    // var color = d3.scale.category20b();
    var cScale = d3.scale.linear().domain([0, 100]).range([0, 2 * Math.PI]);
    var radius = 130;
   	var svg = d3.select('#chart')
  		.append("svg")
  		.attr("preserveAspectRatio", "xMinYMin meet")
  		.attr("viewBox", "-250 -200 500 500")
  		.classed("svg-content", true);
  		
    var arc = d3.svg.arc()
        .innerRadius(innerradius)
        .outerRadius(function(d){return d.radius + innerradius;})
        .startAngle(function(d){return cScale(d.start);})
        .endAngle(function(d){return cScale(d.end);});
    var outerArc = d3.svg.arc()
        .innerRadius(radius)
        .outerRadius(radius);
    
// drag feature on pie chart
    var drag = d3.behavior.drag()
        .on('drag', function(d) {
            if (d3.event.sourceEvent.button == 0) {
                d.radius = Math.sqrt(d3.event.x * d3.event.x + d3.event.y * d3.event.y) - innerradius;
            }
            else if (d3.event.sourceEvent.button == 2){
                d.radius -= Math.sqrt(d3.event.dx * d3.event.dx + d3.event.dy * d3.event.dy);
                d.radius = Math.max (d.radius, 1);
            }
            if(d.radius>120)
                d.radius = 120;
            if(d.radius<10)
                d.radius = 10;
            d.pred = d.radius - 10;
            path.each(function (d2){
                if (d == d2){
                    d3.select(this).select('path').attr('d', arc)
                        .style("fill", function(d){
        						switch (d.id) {
        					//AKI in 1st seven days
        					case 0:
        						if(d.radius<=70) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        					//ICU Admission w/in 30 days
        					case 1:
        						if(d.radius<=70) {
        							d.color = '#03e203';
        							return d.color;
								}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        					//Mechanical ventilation > 2 days
        					case 2:
        						if(d.radius<=70) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        					//Cardiovascular complications
        					case 3:
        						if(d.radius<=70) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        					//Severe sepsis
        					case 4:
        						if(d.radius<=70) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        					//30 day mortality
        					case 5:
        						if(d.radius<=70) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        						
        					default:
        						if(d.radius<=70) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}        					
        					}
        				})
        				
        			d3.select(this).select('svg text')
						.text (function(d) {
							if (d3.select(this).attr("class") == "percentage") {
								switch (d.id) {
							//AKI first seven days
							case 0:
								if (d.radius < 70) {
									d.pred = (d.radius - 10) * (AKI_CUTOFF/60);
								}
								else {
									d.pred = AKI_CUTOFF + ((d.radius - 70) * ((100 - AKI_CUTOFF)/50));
								}
								break;
							//ICU admission
							case 1:
								if (d.radius < 70) {
									d.pred = (d.radius - 10) * (ICU_CUTOFF/60);
								}
								else {
									d.pred = ICU_CUTOFF + ((d.radius - 70) * ((100 - ICU_CUTOFF)/50));
								}
								break;
							//Mechanical ventilation
							case 2:
								if (d.radius < 70) {
									d.pred = (d.radius - 10) * (MV_CUTOFF/60);
								}
								else {
									d.pred = MV_CUTOFF + ((d.radius - 70) * ((100 - MV_CUTOFF)/50));
								}
								break;
							//Cardiovascular complications
							case 3:
								if (d.radius < 70) {
									d.pred = (d.radius - 10) * (CV_CUTOFF/60);
								}
								else {
									d.pred = CV_CUTOFF + ((d.radius - 70) * ((100 - CV_CUTOFF)/50));
								}
								break;
							//Sepsis
							case 4:
								if (d.radius < 70) {
									d.pred = (d.radius - 10) * (SEP_CUTOFF/60);
								}
								else {
									d.pred = SEP_CUTOFF + ((d.radius - 70) * ((100 - SEP_CUTOFF)/50));
								}
								break;
							//Mortality
							case 5:
								if (d.radius < 70) {
									d.pred = (d.radius - 10) * (MORT_CUTOFF/60);
								}
								else {
									d.pred = MORT_CUTOFF + ((d.radius - 70) * ((100 - MORT_CUTOFF)/50));
								}
								break;
							//Default:
							default:
								d.pred = 50;
							}
								d.pred = Math.trunc(d.pred);
								return d.pred + "%";
							}
							else {
								console.log(d.label);
								return d.label;
							}
						}
        			);
                }
            });
        });

    var path = svg.selectAll('g.slice')
        .data(dataset)
        .enter()
        .append('g')
        .attr('class','slice');

    path.append('path')
        .attr('d', arc)
        .call(drag)
        .style("stroke", "#d0d5d9")
        .style("stroke-width", 0.75)
        .style("fill-opacity", 0.65)
        .style("fill", function(d){
        						switch (d.id) {
        					//AKI in 1st seven days
        					case 0:
        						if(d.radius<=69.5) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        					//ICU Admission w/in 30 days
        					case 1:
        						if(d.radius<=69.5) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        					//Mechanical ventilation > 2 days
        					case 2:
        						if(d.radius<=69.5) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        					//Cardiovascular complications
        					case 3:
        						if(d.radius<=69.5) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        					//Severe sepsis
        					case 4:
        						if(d.radius<=69.5) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        					//30 day mortality
        					case 5:
        						if(d.radius<=69.5) {
        							d.color = '#03e203';
        							return d.color;
        						}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}
        						break;
        						
        					default:
        						if(d.radius<=69.5) {
        							d.color = '#03e203';
        							return d.color;
								}
        						else {
        							d.color = '#ff0d00';
        							return d.color;
        						}        					
        					}
        				});
    
        var svgText = path.append("svg:text")
    	  .attr("class","percentage")
		  .attr("transform", function(d) {
			d.innerRadius = 0;
			d.outerRadius = radius;
			return "translate(" + arc.centroid(d) + ")";
			})
		  .style("width","150px")
		  .style("height","150px")
		  //.attr("text-anchor", "middle")
		  .attr("font-size", "10")
		  .style("fill", "#fff")
		  .text (function(d) {
		  		switch (d.id) {
						//AKI first seven days
						case 0:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (AKI_CUTOFF/60);
							}
							else {
								d.pred = AKI_CUTOFF + ((d.radius - 70) * ((100 - AKI_CUTOFF)/50));
							}
							break;
						//ICU admission
						case 1:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (ICU_CUTOFF/60);
							}
							else {
								d.pred = ICU_CUTOFF + ((d.radius - 70) * ((100 - ICU_CUTOFF)/50));
							}
							break;
						//Mechanical ventilation
						case 2:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (MV_CUTOFF/60);
							}
							else {
								d.pred = MV_CUTOFF + ((d.radius - 70) * ((100 - MV_CUTOFF)/50));
							}
							break;
						//Cardiovascular complications
						case 3:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (CV_CUTOFF/60);
							}
							else {
								d.pred = CV_CUTOFF + ((d.radius - 70) * ((100 - CV_CUTOFF)/50));
							}
							break;
						//Sepsis
						case 4:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (SEP_CUTOFF/60);
							}
							else {
								d.pred = SEP_CUTOFF + ((d.radius - 70) * ((100 - SEP_CUTOFF)/50));
							}
							break;
						//Mortality
						case 5:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (MORT_CUTOFF/60);
							}
							else {
								d.pred = MORT_CUTOFF + ((d.radius - 70) * ((100 - MORT_CUTOFF)/50));
							}
							break;
						//Default
						default:
							d.pred = 50;
						}
            		d.pred = Math.trunc(d.pred);
            		return d.pred + "%";
		  });
    			
    path.append('text')
        .attr("transform",function(d){
            // d.outerRadius = 220 + 50;
            // d.innerRadius = 220 + 40;
            var c = arc.centroid(d),
            x = c[0], y = c[1];
            h = Math.sqrt(x*x + y*y);
            return "translate(" + (x/h * 180) +  ',' +
                (y/h * 180) +  ")";
        })
        .attr("text-anchor", "middle") //center the text on its origin
        .attr("dy", ".35em")
        .style("fill", "#d0d5d9")
        .style("font", "bold 9px Arial")
        .each(function (d,i) {
            var arr = dataset[i].label.split(" ");
            var str = '';
            for (i = 0; i < arr.length; i++) {
                str = str + arr[i] + ' ';
                if(str.length>12 || i==arr.length-1) {
                    d3.select(this).append("tspan")
                        .text(str)
                        .attr("dy", i ? "1.2em" : 0)
                        .attr("x", 0)
                        .attr("text-anchor", "middle")
                        .attr("class", "tspan" + i);
                    str = '';
                }
            }
        });

    var grid = d3.svg.area.radial()
        .radius(150);

// to add grid lines
    var sdat = [];
    sdat[0] = radius;

    addCircleAxes = function() {
        var circleAxes, i;

        svg.selectAll('.circle-ticks').remove();

        circleAxes = svg.selectAll('.circle-ticks')
            .data(sdat)
            .enter().append('svg:g')
            .attr("class", "circle-ticks");

        // radial tick lines
        circleAxes.append("svg:circle")
            .attr("r", String)
            .attr("class", "circle")
            .style("stroke", "#d0d5d9")
            .style("stroke-width", 1.5)
            .style("opacity", 0.75)
            .style("fill", "none");
    };

    addCircleAxes();
}
