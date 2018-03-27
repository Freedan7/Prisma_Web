/**
 *	Prototype by Raviteja Ganireddy on 24/03/2017.
 *	Final Version by Daniel Freeman
 */
 
// Cutoff constants
var AKI_CUTOFF = 35;
var ICU_CUTOFF = 35;
var MV_CUTOFF = 13;
var CV_CUTOFF = 7;
var SEP_CUTOFF = 6;
var NEU_CUTOFF = 7;
var VTE_CUTOFF = 3;
var WND_CUTOFF = 10;
var MORT_CUTOFF = 5;

// A global array to hold data from database.
var dataset = [];

/**
 * @summary Generates an svg chart.
 *
 * This function generates an svg chart. Within that chart are a number of
 * slices. Each slice displays a corresponding percentage and label.
 *
 * @global type $COMPLICATION_CUTOFF Complication cutoffs are constants which
 * indicate a concerning risk percentage for a given complication.
 *
 * @param type $var labels. This is a database object containing several
 * complications, as well as corresponding values for said complications.
 *
 * @returns type none.
 */
function generatechart(labels, complicationPerc) {
	// An array for storing cutoff values, and a variable to store its length
 	var cutoff = [AKI_CUTOFF, ICU_CUTOFF, MV_CUTOFF, CV_CUTOFF, SEP_CUTOFF, 
 					  NEU_CUTOFF, VTE_CUTOFF, WND_CUTOFF];
	var numComplications = cutoff.length;
	
	// Populate the dataset array with data from database.
    for(i=0;i<labels.length;i++){
        dataset.push({});
    	dataset[i].id = i;
        //dataset[i].label = labels[i];
        dataset[i].radius = complicationPerc[i] + 20;
        dataset[i].start = 1 + 100 / labels.length * i;
        dataset[i].end = 100/labels.length * (i+1) - 1;
        dataset[i].pred = complicationPerc[i];
        // console.log(dataset[i].id + ' = ' + dataset[i].label);
    }

    //Set label names
    dataset[0].label = 'Acute kidney injury';
    dataset[1].label = 'ICU admission more than 48 hours';
    dataset[2].label = 'Mechanical ventilation more than 48 hours';
    dataset[3].label = 'Cardiovascular complications';
    dataset[4].label = 'Sepsis';
    dataset[5].label = 'Neurologic complications including delirum';
    dataset[6].label = 'Venous thromboembolism ';
    dataset[7].label = 'Wound complications';
    
    // Sets slices to cutoff length if complicationPerc returns -1.
    for (i = 0; i < numComplications; i++) {
    	if (complicationPerc[i] == -1) {
    		dataset[i].radius = cutoff[i] + 20;
    	}
    }
    
    // Adjust pie chart slices according to the initial dataset radius.
    for (i = 0; i < numComplications; i++) {
    	if (dataset[i].radius >= cutoff[i] + 20) {
    		dataset[i].radius = 70 
    			+ (dataset[i].radius - 20 - cutoff[i]) / ((100 - cutoff[i])/50);
    		console.log('dataset radius = ' + dataset[i].radius);
		}
		else {
			dataset[i].radius = ((dataset[i].radius - 20) 
				* ((120 / cutoff[i]) / 2)) + 10;
			console.log('dataset radius = ' + dataset[i].radius);
		}
    }

    /* 
     * Defines which HTML element will contain the chart, and sets the values
     * for that element's boundaries.
     */
    var chartContainer = document.getElementById('chart');
    var bodyRect = document.body.getBoundingClientRect();
    var chartRect = chartContainer.getBoundingClientRect();
    var offset = (chartRect.top - bodyRect.top);
    
    // Sets the scale for the pie chart and appends it to the document.
    var innerradius = 10;
    var cScale = d3.scale.linear().domain([0, 100]).range([0, 2 * Math.PI]);
    var radius = 130;
   	var svg = d3.select('#chart')
  		.append('svg')
  		.attr('preserveAspectRatio', 'xMinYMin meet')
  		.attr('viewBox', '-250 -200 500 400')
  		.classed('svg-content', true);
  	
  	// Defines two svg objects to control layering.
  	var layer1 = svg.append('g');
    var layer2 = svg.append('g');
  	
  	// Defines an arc for the pie chart slices.
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
        .on('drag', 
        	/**
        	 * @summary Defines the drag behavior for the chart slices
        	 *
        	 * This function allows the slices of the pie chart to be resized
        	 * by dragging them with a mouse.
        	 *
        	 * @param type $var d. Specifies the current data element.
        	 *
        	 * @return type none.
        	 */
        	function(d) {
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
				path.each(
					/**
					 * @summary Defines the drag behavior for the chart slices
					 *
					 * This function allows the chart slices' radii to be 
					 * manipulated via mouse drags, and specifies how the slices
					 * and their text should change based on their radii.
					 *
					 * @param type $var d2. Specifies the current data element.
					 *
					 * @return type none.
					 */
					function (d2){
						if (d == d2){
						d3.select(this).select('path').attr('d', arc)
							.style('fill', 
								/**
								 * @summary Adjusts slice color based on radius
								 *
								 * This function adjusts the chart slice colors
								 * based on the radii of said slices.
								 *
								 * @param type $var d. Specifies the current data element.
								 *
								 * @return type string. Returns a string specifying the
								 * color of the slice.
								 */
								function(d){
										if(d.radius<=70) {
											d.color = '#03e203';
											return d.color;
										}
										else {
											d.color = '#ff0d00';
											return d.color;
										}
								}
							)
							
						d3.select(this).select('svg text')
							.text (
								/**
								 * @summary Adjusts percentage text based on radius
								 *
								 * This function adjusts the percentage text on 
								 * chart slices based on the radii of said slices.
								 *
								 * @param type $var d. Specifies the current data element.
								 *
								 * @return type string. Returns a float with an attached
								 * percentage symbol as a string.
								 */
								function(d) {
									if (d3.select(this).attr('class') == 'percentage') {
										// Adjusts percentage displayed based on cutoffs
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
												d.pred = (d.radius - 10) * (NEU_CUTOFF/60);
											}
											else {
												d.pred = NEU_CUTOFF + ((d.radius - 70) * ((100 - NEU_CUTOFF)/50));
											}
											break;
										//???
										case 6:
											if (d.radius < 70) {
												d.pred = (d.radius - 10) * (VTE_CUTOFF/60);
											}
											else {
												d.pred = VTE_CUTOFF + ((d.radius - 70) * ((100 - VTE_CUTOFF)/50));
											}
											break;
										//???
										case 7:
											if (d.radius < 70) {
												d.pred = (d.radius - 10) * (WND_CUTOFF/60);
											}
											else {
												d.pred = WND_CUTOFF + ((d.radius - 70) * ((100 - WND_CUTOFF)/50));
											}
											break;
										//Default:
										default:
											d.pred = 50;
									}
										d.pred = Math.trunc(d.pred);
										return d.pred + '%';
									}
									else {
										console.log(d.label);
										return d.label;
									}
								}
							);
						}
					}
				);
        	}
        );

	// Place chart path on svg layer 2.
    var path = layer2.selectAll('g.slice')
        .data( dataset )
        .enter()
        .append( 'g' )
        .attr( 'class', 'slice' );

	// Create and fill the pie chart slices.
    path.append('path')
        .attr('d', arc)
        .call(drag)
        .style('stroke', '#d0d5d9')
        .style('stroke-width', 0.75)
        .style('fill-opacity', 0.65)
        .style('fill', 
        	/**
        	 * @summary Sets the fill color of the pie chart slices
        	 *
        	 * If a slice's radius is less than or equal to 69.5, this indicates
        	 * that the complication that slice represents is below the cutoff
        	 * point. Thus, the slice will display as green. Otherwise, the
        	 * slice will display as red, indicating that the complication has
        	 * reached or surpassed the cutoff point.
        	 *
        	 * @param type $var d. This variable holds the attributes of the 
        	 * path svg, including its color.
        	 *
        	 * @return type string. Returns a hexadecimal rgb string.
        	 */
        	function(d){
				console.log ('d.id = ' + d.id );
				
				if (complicationPerc[d.id] === -1) {
					return '#ff6e66';
				}
				else {
					if(d.radius<=69.5) {
						d.color = '#03e203';
						return d.color;
					}
					else {
						d.color = '#ff0d00';
						return d.color;
					}
				}
			}
		);
    
    // Appends a percentage as text to each slice of the pie chart.
    var svgText = path.append('svg:text')
      .attr('class','percentage')
	  .attr('transform',
	  		/**
        	 * @summary Generates a transform for svg elements
        	 *
        	 * This function gets the coordinates of a chart slice, and creates
        	 * a transform string based on said coordinates.
        	 *
        	 * @param type $var d. Specifies the current data element.
        	 *
        	 * @return type string. Returns a string representing the transform
        	 * to be performed.
        	 */
	  		function(d){
			    var c = arc.centroid(d),
			    x = c[0], y = c[1];
			    h = Math.sqrt(x*x + y*y);
		  		return 'translate(' + (x/h * 70) +  ',' +
			   		(y/h * 70) +  ')';
        	}
    	)
		  .style('width','150px')
		  .style('height','150px')
		  .attr('font-size', '12')
		  .attr('text-anchor', 'middle')
		  .attr('pointer-events', 'none')
		  .style('fill', '#fff')
		  .text (
		  	/**
        	 * @summary Sets the percentage displayed on the pie chart slices
        	 *
        	 * This function calculates what risk percentage should be displayed
        	 * on a particular chart slice, based on that slice's radius, and a
        	 * cutoff constant.
        	 *
        	 * @param type $var d. Specifies the current data element.
        	 *
        	 * @return type string. Returns a float with a percentage attached.
        	 */
		  	function(d) {
		  		switch (d.id) {
						// AKI first seven days
						case 0:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (AKI_CUTOFF/60);
							}
							else {
								d.pred = AKI_CUTOFF + ((d.radius - 70) * ((100 - AKI_CUTOFF)/50));
							}
							break;
						// ICU admission for more than 48 hrs
						case 1:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (ICU_CUTOFF/60);
							}
							else {
								d.pred = ICU_CUTOFF + ((d.radius - 70) * ((100 - ICU_CUTOFF)/50));
							}
							break;
						// Mechanical ventilation
						case 2:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (MV_CUTOFF/60);
							}
							else {
								d.pred = MV_CUTOFF + ((d.radius - 70) * ((100 - MV_CUTOFF)/50));
							}
							break;
						// Cardiovascular complications
						case 3:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (CV_CUTOFF/60);
							}
							else {
								d.pred = CV_CUTOFF + ((d.radius - 70) * ((100 - CV_CUTOFF)/50));
							}
							break;
						// Sepsis
						case 4:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (SEP_CUTOFF/60);
							}
							else {
								d.pred = SEP_CUTOFF + ((d.radius - 70) * ((100 - SEP_CUTOFF)/50));
							}
							break;
						// Neurological complications
						case 5:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (NEU_CUTOFF/60);
							}
							else {
								d.pred = NEU_CUTOFF + ((d.radius - 70) * ((100 - NEU_CUTOFF)/50));
							}
							break;
						// Venous Thromboembolism
						case 6:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (VTE_CUTOFF/60);
							}
							else {
								d.pred = VTE_CUTOFF + ((d.radius - 70) * ((100 - VTE_CUTOFF)/50));
							}
							break;
						// Wound comlications
						case 7:
							if (d.radius < 70) {
								d.pred = (d.radius - 10) * (WND_CUTOFF/60);
							}
							else {
								d.pred = WND_CUTOFF + ((d.radius - 70) * ((100 - WND_CUTOFF)/50));
							}
							break;
						// Default
						default:
							d.pred = 50;
						}
						
					console.log('dataset prediction = ' + d.pred);
            		d.pred = Math.round(d.pred);
            		return d.pred + '%';
		  		}
		  );
	
	// Appends a text label to each slice of the pie chart.
    path.append('text')
        .attr('transform',
        	/**
        	 * @summary Generates a transform for svg elements
        	 *
        	 * This function gets the coordinates of a chart slice, and creates
        	 * a transform string based on said coordinates.
        	 *
        	 * @param type $var d. Specifies the current data element.
        	 *
        	 * @return type string. Returns a string representing the transform
        	 * to be performed.
        	 */
        	function(d){
				var c = arc.centroid(d),
					x = c[0], y = c[1];
				h = Math.sqrt(x*x + y*y);
				
				switch (d.id) {
					case 0:
						return 'translate(' + (x/h * 180) +  ',' +
						(y/h * 180) +  ')';
					
					case 1:
						return 'translate(' + (x/h * 185) +  ',' +
						(y/h * 185) +  ')';
						
					case 2:
						return 'translate(' + (x/h * 175) +  ',' +
						(y/h * 175) +  ')';
						
					case 3:
						return 'translate(' + (x/h * 155) +  ',' +
						(y/h * 155) +  ')';
						
					case 4:
						return 'translate(' + (x/h * 155) +  ',' +
						(y/h * 155) +  ')';
					
					case 5:
						return 'translate(' + (x/h * 175) +  ',' +
						(y/h * 175) +  ')';
						
					case 6:
						return 'translate(' + (x/h * 190) +  ',' +
						(y/h * 190) +  ')';
						
					case 7:
						return 'translate(' + (x/h * 165) +  ',' +
						(y/h * 165) +  ')';
				}
			}
		)
        .attr('text-anchor', 'middle')
        .attr('dy', '.35em')
        .style('fill', '#d0d5d9')
        .style('font', 'bold 12px Arial')
        .each(
        	/**
        	 * @summary Wraps the label text 
        	 *
        	 * This function cuts off svg text of a specific length, and places
        	 * subsequent text on a new line.
        	 *
        	 * @param type $var d. Specifies the current data element.
        	 * @param type $var i. Specifies the index of the current data
        	 * element.
        	 *
        	 * @return type none.
        	 */
        	function (d,i) {
				var arr = dataset[i].label.split(' ');
				var str = '';
				
				for (i = 0; i < arr.length; i++) {
					str = str + arr[i] + ' ';
					if(str.length>5 || i==arr.length-1) {
						d3.select(this).append('tspan')
							.text(str)
							.attr('dy', i ? '1.2em' : 0)
							.attr('x', 0)
							.attr('text-anchor', 'middle')
							.attr('class', 'tspan' + i);
						str = '';
					}
				}
				
				console.log ( 'strings created' );
			}
		);
	
	/*
	 * Appends a circle to the edge of the chart for each slice of the pie 
	 * chart. Clicking on these circles reveals the slice label.
	 */
	path.append('svg:circle')
			.attr('transform',
				/**
				 * @summary Generates a transform for svg elements
				 *
				 * This function gets the coordinates of a chart slice, and creates
				 * a transform string based on said coordinates.
				 *
				 * @param type $var d. Specifies the current data element.
				 *
				 * @return type string. Returns a string representing the transform
				 * to be performed.
				 */
				function(d){
					var c = arc.centroid(d),
					x = c[0], y = c[1];
					h = Math.sqrt(x*x + y*y);
					return 'translate(' + (x/h * 130) +  ',' +
						(y/h * 130) +  ')';
				}
			)
            .attr('r', '5')
            .attr('class', 'labelCircle')
            .style('stroke', '#d0d5d9')
            .style('stroke-width', 1.5)
            .style('opacity', 1)
            .style('fill', '#000');

	// Create svg to hold grid.
    var grid = d3.svg.area.radial()
        .radius(150);

	// Add grid lines.
    var sdat = [];
    sdat[0] = radius;

	/**
	 * @summary Add circle axes to graph
	 *
	 * Adds circle axes to the graph, and defines their style attributes.
	 *
	 * @return type none.
	 */
    addCircleAxes = function() {
        var circleAxes, i;

        layer1.selectAll('.circle-ticks').remove();

        circleAxes = layer1.selectAll('.circle-ticks')
            .data(sdat)
            .enter().append('svg:g')
            .attr('class', 'circle-ticks');

    // radial tick lines
    circleAxes.append('svg:circle')
        .attr('r', String)
        .attr('class', 'circle')
        .style('stroke', '#d0d5d9')
        .style('stroke-width', 1.5)
        .style('opacity', 0.75)
        .style('fill', 'none');
    };

    addCircleAxes();
}

/**
 * @summary Get the dataset object
 *
 * @return type array. Returns the global dataset array.
 */
function getDataset () {
	return dataset;
}