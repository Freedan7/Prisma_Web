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
 
// Declare global dataset array
var dataset = [];

/**
 * @summary Rounds a number
 *
 * This function rounds a float to a specified number of decimal spaces.
 *
 * @param type $var value. This is the float that will be rounded.
 * @param type $var decimals. An integer specifying what decimal place the
 * float will be rounded to.
 *
 * @returns type float. Returns a rounded float.
 */
function round(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

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
function generatechart_thumb( labels, mortRisk ) {
	// An array for storing cutoff values, and a variable to store its length
 	var cutoff = [AKI_CUTOFF, ICU_CUTOFF, CV_CUTOFF, NEU_CUTOFF, 
 					  MV_CUTOFF, SEP_CUTOFF, VTE_CUTOFF, WND_CUTOFF];
	var numComplications = cutoff.length;

	// Populate dataset array with data from database
    for (i = 0; i < labels.length; i++){
        dataset.push({});
        //dataset[i].label = labels[i].complicationname;
        dataset[i].radius = labels[i].riskScore * 100 + 20;
        dataset[i].riskNum = dataset[i].radius;
        dataset[i].start = 1 + 100 / labels.length * i;
        dataset[i].end = 100/labels.length * (i+1) - 1;
        dataset[i].id = i;
        dataset[i].topFactors = [ labels[i].topfeature1, labels[i].topfeature2, labels[i].topfeature3 ];
        console.log (dataset[i].topFactors);
        for( j=0; j < dataset[i].topFactors.length; j++ ){
           dataset[i].topFactors[j].isinclude = true;
        }
        //console.log(dataset[i].id + ' = ' + labels[i][0].label);
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
    
    // Multiply mortRisk by 100 and round
    mortRisk = round( mortRisk * 100, 1);
    
    // Adjust pie chart slices according to the initial dataset radius.
    for (i = 0; i < numComplications; i++) {
    	console.log("Complication " + dataset[i].label + "\'s cutoff = " + cutoff[i] );
    	if (dataset[i].radius >= cutoff[i] + 20) {
    	dataset[i].radius = 70 
    		+ (dataset[i].radius - 20 - cutoff[i]) / ((100 - cutoff[i])/50);
		}
		else {
			dataset[i].radius = ((dataset[i].radius - 20) 
				* ((120 / cutoff[i]) / 2)) + 10;
		}
    }
    
    // Declare variables for chart svg
    var innerradius = 10;
    var cScale = d3.scale.linear().domain([0, 100]).range([0, 2 * Math.PI]);
    var radius = 130;
    
    // Create svg container to hold chart
  	var svg = d3.select('.predictionChartThumb')
    	.append('svg')
  		.attr('preserveAspectRatio', 'xMinYMin meet')
  		.attr('viewBox', '-250 -280 500 500')
  		.style('background-color',
  			/**
			 * @summary Sets the background color of the chart container.
			 *
			 * This function sets the background color of the chart container
			 * depending on whether or not the mortality risk is past its
			 * cutoff value.
			 *
			 * @global type $MORT_CUTOFF The MORT_CUTOFF constant specifies a
			 * concerning likelihood of mortality.
			 *
			 * @returns type string. Returns a string representing the rgb
			 * value to set the background color to.
			 */
			function() {
				if (mortRisk >= MORT_CUTOFF) {
					return 'rgba(255, 0, 0, 0.35)';
				}
				else {
					return 'rgba(255, 0, 0, 0)';
				}
			}
		)
  		.style('border-radius', '20px')
  		.classed('svg-content', true);
    
    // Layers for controlling the order in which chart elements stack
    var layer1 = svg.append('g');
    var layer2 = svg.append('g');
        
    var arc = d3.svg.arc()
        .innerRadius(innerradius)
        .outerRadius(function(d){return d.radius + innerradius;})
        .startAngle(function(d){return cScale(d.start);})
        .endAngle(function(d){return cScale(d.end);});

    var path = layer2.selectAll('g.slice')
        .data(dataset)
        .enter()
        .append('g')
        .attr('class','slice');

    path.append('path')
        .attr('d', arc)
        .attr('class', 'arc')
        .style('stroke', '#d0d5d9')
        .style('stroke-width', 0.75)
        .style('fill-opacity', 0.65)
        .style('fill',
        	/**
        	 * @summary Sets the initial path color
        	 *
        	 * This function sets the chart paths' initial colors based on 
        	 * their radii.
        	 *
        	 * @param type $var d. Specifies the current data element.
        	 *
        	 * @return type string. Returns a hexadecimal rgb string.
        	 */
			function(d){

					if(d.radius<70)return '#81fd81';
					else return '#ff6e66';
				
			}
		)
        .attr('id',function(d){return d.id});

	//Text to show labels on chart
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
						return 'translate(' + (x/h * 190) +  ',' +
						(y/h * 190) +  ')';
						
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
        .attr('class', 'label')
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
			}
        );

	//Text to show risk percentage as number on chart
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
		  .attr('text-anchor', 'middle')
		  .attr('font-size', '12')
		  .style('fill', '#fff')
		  .text(function(d) {
            		d.pred = round(round(d.riskNum,2) -20,1);
            		return d.pred + '%';
		  });
	
	// Append a circle for each pie slice which reveals a label when clicked
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

	// Create svg to hold graph grid.
    var grid = d3.svg.area.radial()
        .radius(150);

	// Add grid lines.
    var sdat = [];
    sdat[0] = radius;

	// Append a title to the miniature computer results chart
	var svgText = svg.append('svg:text')
		  .attr('class','thumbLabel')
		  .attr('transform', 'translate (0 -220)')
		  .attr('text-anchor', 'middle')
		  .attr('font-size', '48')
		  .style('fill', '#fff')
		  .text('Algorithm Scores');
	
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
