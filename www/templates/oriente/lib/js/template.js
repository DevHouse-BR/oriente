/* template.js,  */

var YOOTemplate = {
		
	start: function() {

		/* Match height of div tags */
		matchHeights();

		/* Accordion menu */
		new YOOAccordionMenu('div#middle ul.menu li.toggler', 'ul.accordion', { accordion: 'slide' });

		/* Dropdown menu */
		var dropdown = new YOODropdownMenu('menu', { mode: 'default', dropdownSelector: 'div.dropdown', transition: Fx.Transitions.Expo.easeOut });
		dropdown.matchUlHeight();

		/* Fancy menu */
		new YOOFancyMenu('menu', { mode: 'move', transition: Fx.Transitions.expoOut, duration: 500 });

		/* set hover color */
		switch (YtSettings.color) {
			case 'ocean':
				var menuEnter = '#cbdbe1';
				var menuLeave = '#DEEAEF';
				var submenuEnter = '#273c48';
				var submenuLeave = '#2e4552';
				break;	
			case 'red':
				var menuEnter = '#e6e3e1';
				var menuLeave = '#EFEEED';
				var submenuEnter = '#292222';
				var submenuLeave = '#312828';
				break;	
			case 'green':
				var menuEnter = '#dadcc1';
				var menuLeave = '#E6E8D0';
				var submenuEnter = '#2f2f27';
				var submenuLeave = '#36362e';
				break;	
			case 'brown':
				var menuEnter = '#d0cdbc';
				var menuLeave = '#DBD9CC';
				var submenuEnter = '#45403b';
				var submenuLeave = '#4e4943';
				break;	
			case 'ecru':
				var menuEnter = '#cdccb7';
				var menuLeave = '#D8D7C7';
				var submenuEnter = '#2a2a22';
				var submenuLeave = '#313128';
				break;	
			case 'blue':
				var menuEnter = '#d9e8f7';
				var menuLeave = '#EBF3FF';
				var submenuEnter = '#154d85';
				var submenuLeave = '#1b558f';
				break;	
			case 'white':
				var menuEnter = '#c9d1d9';
				var menuLeave = '#D7DEE6';
				var submenuEnter = '#576069';
				var submenuLeave = '#646e78';
				break;	
			default:
				var menuEnter = '#C8D0D7';
				var menuLeave = '#D8DEE2';
				var submenuEnter = '#262A2D';
				var submenuLeave = '#2B2F32';
		}


		/* Morph: main menu - level2 (bg) */
		var menuEnter = { 'background-color': menuEnter };
		var menuLeave = { 'background-color': menuLeave };

		new YOOMorph('#menu a.level2', menuEnter, menuLeave,
			{ transition: Fx.Transitions.linear, duration: 0, ignore: '#menu li.level2 a.parent' },
			{ transition: Fx.Transitions.sineIn, duration: 500 });

		/* Morph: mod-fading sub menu - level1 (bg) */
		var submenuEnter = { 'background-color': submenuEnter };
		var submenuLeave = { 'background-color': submenuLeave };

		new YOOMorph('div.mod-sidebar ul.menu li.level2 a, div.mod-sidebar ul.menu li.levek2 span.separator', submenuEnter, submenuLeave,
			{ transition: Fx.Transitions.linear, duration: 0 },
			{ transition: Fx.Transitions.sineIn, duration: 300 });

		/* Smoothscroll */
		new SmoothScroll({ duration: 500, transition: Fx.Transitions.Expo.easeOut });

		/* Match height of div tags */
		function matchHeights() {
			YOOBase.matchHeight('div.headerbox div.deepest', 20);
			YOOBase.matchHeight('div.topbox div.deepest', 20);
			YOOBase.matchHeight('div.bottombox div.deepest', 20);
			YOOBase.matchHeight('div.maintopbox div.deepest', 20);
			YOOBase.matchHeight('div.mainbottombox div.deepest', 20);
			YOOBase.matchHeight('div.contenttopbox div.deepest', 20);
			YOOBase.matchHeight('div.contentbottombox div.deepest', 20);
		}

	}

};

/* Add functions on window load */
window.addEvent('domready', YOOTemplate.start);