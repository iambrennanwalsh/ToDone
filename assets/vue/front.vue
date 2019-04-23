<script>
import notice from './front/notice.vue'
import slider from './front/slider.vue'
import contact from './front/contact.vue'

export default {}	
	
new Vue({
	
	components: {
		'slider': slider,
		'notice': notice,
		'contact': contact
	},
	
	el: "#front"
	
})
</script>