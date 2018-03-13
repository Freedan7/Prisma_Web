// Define Tooltip Div, label and percent. Set tooltip visibility to false.
var HTMLtooltip = d3.select('.tTip');
var tooltipLabel = d3.select('.tTip').select('#tTipLabel');
var tooltipPercent = d3.select('.tTip').select('#tTipPercent');
var tooltipVisible = false;

d3.selectAll('svg').selectAll('g.slice').select('path')
		.on('mouseover', 
			/**
			 * @summary Initiates HTML label text change
			 *
			 * This function calls two additional functions which change the
			 * text on an HTML label.
			 *
			 * @param type $var d. Specifies the current data element.
			 *
			 * @returns type none.
			 */
			function (d) {
					tooltipLabel.text(function () {
						/*console.log('d is equal to ' + d.id);
						if (d.id == 7) {
        					return 'Post-op infection & Mechanical Wound & Procedural complications';
        				}
        				else {
        					return d.label;
        				}*/
        				return d.label;
					});
					tooltipPercent.text(function () {return d.pred + '%';});
			}
		)
        .on('mousemove',
        	/**
			 * @summary Makes HTML tooltip visible and sets its location
			 *
			 * This function sets the style of the HTML tooltip to visible,
			 * and generates a set of coordinates for the tooltip.
			 *
			 * @returns type none.
			 */
			function () {
					HTMLtooltip.style('visibility', 'visible');
		
					var matrix = this.getScreenCTM()
							.translate(+this.getAttribute('cx'),
									 +this.getAttribute('cy'));

					//Absolute HTML tooltip
					HTMLtooltip
						.style('left', 
							   (d3.event.pageX) + 'px')
						.style('top',
							   (d3.event.pageY) + 'px');
			}
        )
        .on('mouseout', 
        	/**
			 * @summary Makes HTML tooltip invisible
			 *
			 * This function simply sets the HTML tooltip's visibility 
			 * attribute to hidden.
			 *
			 * @returns type none.
			 */
        	function (d, i) {
        		return HTMLtooltip.style('visibility', 'hidden');
        })
        
        d3.selectAll('.labelCircle')
        	.on('click', function (d) {
        		if (tooltipVisible == false) {
        			tooltipLabel.text(function () {
        				if (d.id == 7) {
        					return 'Post-op infection & Mechanical Wound & Procedural complications';
        				}
        				else {
        					return d.label;
        				}
        			});
        			tooltipPercent.text(function () {return d.pred + '%';});
        			HTMLtooltip.style('visibility', 'visible');
        		
					var matrix = this.getScreenCTM()
							.translate(+this.getAttribute('cx'),
									 +this.getAttribute('cy'));

					//Absolute HTML tooltip
					HTMLtooltip
						.style('left', 
							   (d3.event.pageX) + 'px')
						.style('top',
							   (d3.event.pageY) + 'px');
        		
        			tooltipVisible = true;
        		}
        		else if (tooltipVisible == true) {
        			HTMLtooltip.style('visibility', 'hidden');
        		
        			tooltipVisible = false;
        		}
        	});