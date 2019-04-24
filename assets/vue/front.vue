<script>
import modal from './base/modal'
import slider from './front/slider'
import contact from './front/contact'

export default {}	
	
new Vue({
	
	components: {
		'slider': slider,
		'modal': modal,
		'contact': contact
	},
	
	el: "#front"
	
})
</script>