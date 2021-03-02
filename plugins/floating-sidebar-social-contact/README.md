# socialfloating.js

A plugin based on jQuery to add floating share and contact buttons to your website.

Check out the **demo** to see it in action!

# Usage

## 1. Installation

1. Head over to the [releases](https://github.com/ixtlistudios/jquery.socialfloating.js/releases) section
2. Download `jquery.socialfloating.zip`
3. Extract the ZIP archive and locate the `jquery.socialfloating.js` and `jquery.socialfloating.min.js` files
	* Use `jquery.socialfloating.js` if you want to snoop around in the code
	* Use `jquery.socialfloating.min.js` for deployment, because it has a smaller file size
4. Copy the file of your choice into your project

## 2. Preparation

Include the script like any other Javascript library:
`<script src="path/to/jquery.socialfloating.js"></script>`

## 3. Run socialfloating.js

You can call the socialfloating.js main function, using the default parameters or your own ones.

```javascript
$.socialfloating();
```

## 4. Configuration

Load socialfloating.js and configure the bar:

```javascript
$.socialfloating({
	theme: 'light',
	opaque: false,
	effect: null,
	icons: 'fontawesome5',
	showHidebutton: true,
	container: 'socialfloating',
	position: 'left',
	buttons: [
		{
			enabled: true,
			icon: 'fas fa-facebook-square',
			name: 'facebook',
			link: 'https://www.facebook.com',
			title: 'Visit us on Facebook',
			color: '#3b5998'
		}
	]
});
```
You can use an array of objects in the `buttons` property to group buttons

### Configuration options

key | type | default value | values
-|-|-|-
`theme` | string | `'light'` | `'light'` / `'dark'` / `'gray'` / `'color'`
`opaque` | boolean | `false` | `true` / `false`
`effect` | string | `null` | `null` / `'scroll'`
`icons` | string | `'fontawesome5'` | `'fontawesome5'` / `'fontawesome4'` / `'semanticui'`
`showHideButton` | boolean | true | `true` / `false`
`container` | string | `socialfloating` | `any`
`position` | string | `'left'` | `left` / `right`
`buttons` | array\<object\> / array\<`buttons`\> | `null` | `[ buttons.button ]` / `[ buttons ]`
`buttons.button` | object | | `{ icon: buttons.button.icon, enabled: buttons.button.enabled, link: buttons.button.link }`
`buttons.button.icon` | string |  | Valid HTML class from `icons` property
`buttons.button.enabled` | boolean | true | `true` / `false`
`buttons.button.link` | string | `#` | Valid URL
`buttons.button.title` | string | ` ` | Escaped string
`buttons.button.color` | string | `#8e8e93` | Valid CSS color

# License

This project is licensed under the terms of the [MIT license](http://www.opensource.org/licenses/MIT).

# Copyright

Copyright &copy; 2020 Ixtli Studios.
