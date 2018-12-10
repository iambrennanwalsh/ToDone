/**
* @name:          scripts.dash.js
* @description:   This script imports all of the required javascript and css for the front portion of the site.
*/

if (document.querySelector('body.lists') !== null) {
	
	var lists = new Vue({
		el: "#root",
		
		data: {
			state: '',
			render: '',
			title: '',
			content: '',
			button: '',
			listid: ''
		},
		
		methods: {
			
			stateChange: function(event) {
				event.preventDefault();
				if (this.state === '') {this.state = 'is-active ';}
				else {this.state = '';}},
			
			renderModal: function(event) {
				event.preventDefault();
				this.stateChange(event);
				this.render = event.target.dataset.render;
				if (this.render == 'delete') {
					this.listid = event.target.parentElement.dataset.listid;
					this.state += 'deletelist';
					this.title = 'Delete a list';
					this.content = '<p>Are you absolutely sure you want to delete this list? There is no recovering it?</p>';
					this.button = 'Confirm and Delete';}
				if (this.render == 'add') {
					this.state += 'addlist';
					this.title = 'Create a new list.';
					this.content = '<div class="field is-horizontal"><div class="field-label is-normal"><label class="label has-text-dark">List Title</label></div><div class="field-body"><div class="field"><div class="control"><input class="input" type="text" name="title" placeholder="e.g. Meeting Times.."></div></div></div></div><div class="field is-horizontal"><div class="field-label is-normal"><label class="label has-text-dark">List Description</label></div><div class="field-body"><div class="field"><div class="control"><textarea class="textarea" name="message" placeholder="What\'s this list all about?"></textarea></div></div></div></div>';
					this.button = 'Create List';}},
			
			submitForm: function(event) {
				event.preventDefault();
				this.stateChange(event);
				this.ajax(event);},
			
			ajax: function(event) {
				if(this.render == 'add') {
					var form = document.getElementById('newList');
					var data = new FormData(form);
					var created = new Date();
					var dd = created.getDate();
					var mm = created.getMonth()+1;
					var yyyy = created.getFullYear();
					if(dd<10) {dd = '0'+dd;} 
					if(mm<10) {mm = '0'+mm;} 
					created = mm + '/' + dd + '/' + yyyy;
					data.set('created', created);
    			var xhr = new XMLHttpRequest();
					xhr.addEventListener("load", event => {
						var json = JSON.parse(event.target.responseText);
						var response = '<div class="list column box is-6"><p class="is-size-3"><strong>' + json.title + '</strong></p><p class="m-bottom-10 has-text-dark">' + json.message + '</p><p class="m-bottom-10"><span class="tag is-info m-right-10">9/10  Completed</span><span class="tag is-dark">Created: ' + json.created + '</span></p><progress class="progress is-primary" value="90" max="100">90%</progress></div>';
        		var li = '<li><a>' + json.title + '</a></li>';
						var newel = document.createElement("div");
						var newli = document.createElement("div");
						document.getElementById('lists').appendChild(newel);
						document.getElementById('sidelists').appendChild(newli);
						newel.outerHTML = response;
						newli.outerHTML = li;
						});
					xhr.open("POST", "https://bizplan.local/addlist");
					xhr.send(data);}
				
				if(this.render == 'delete') {
					var id = this.listid;
					var jsonData = {id: id};
					var formatted = JSON.stringify(jsonData);
					var xhr = new XMLHttpRequest();
					xhr.addEventListener("load", event => {
						var datas = document.querySelectorAll("[data-listid='" + id + "']");
						for(i=0; i<datas.length; i++) {datas[i].outerHTML = '';}
					});
					xhr.open("POST", "https://bizplan.local/deletelist");
					xhr.send(formatted);
				}
			},
			
	}
});
	
}
