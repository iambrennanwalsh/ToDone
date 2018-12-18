<script>
Vue.component('list', {
	data: function() {
		return {
			loader: false,
		}
	},
	methods:	{
		checkit: function(event) {
				if (event.target.firstChild.classList.contains('fa-check')) {
					event.target.firstChild.classList.remove('fa-check');
					event.target.firstChild.nextElementSibling.style.textDecoration = 'unset';
					event.target.parentElement.style.background = 'unset';
					var id = event.target.parentElement.getAttribute('data-taskid');
					var listid = document.getElementById('list').dataset.id;
					var jsonData = {id: id, listid: listid, change: 0};
					var formatted = JSON.stringify(jsonData);
					var xhr = new XMLHttpRequest();
					xhr.open("POST", "https://bizplan.local/checkit");
					xhr.send(formatted);
				}
				else {
					event.target.firstChild.classList.add('fa-check');
					event.target.firstChild.nextElementSibling.style.textDecoration = 'line-through';
					event.target.parentElement.style.background = '#e0fae0';
					var id = event.target.parentElement.getAttribute('data-taskid');
					var listid = document.getElementById('list').dataset.id;
					var jsonData = {id: id, listid: listid, change: 1};
					var formatted = JSON.stringify(jsonData);
					var xhr = new XMLHttpRequest();
					xhr.open("POST", "https://bizplan.local/checkit");
					xhr.send(formatted);
				}
			},
		addTask: function(event) {
				this.loader = true;
				var form = document.getElementById('addtask');
				var data = new FormData(form);
				var url = window.location.pathname.split("/").pop()
				var modified = new Date();
				var dd = modified.getDate();
				var mm = modified.getMonth()+1;
				var yyyy = modified.getFullYear();
				if(dd<10) {dd = '0'+dd;} 
				if(mm<10) {mm = '0'+mm;} 
				modified = mm + '/' + dd + '/' + yyyy;
				data.set('modified', modified);
				data.set('id', url);
    		var xhr = new XMLHttpRequest();
				xhr.addEventListener("load", event => {
					this.loader = false;
					var task = document.getElementById('newtask').value;
					var response = '<li class="has-text-dark"><label v-on:click="checkit"><span class="check fa m-left-0"></span><span class="taskname m-left-50">' + task + '</span></label><span class="delete is-pulled-right"></span></li>';
					var newtask = document.createElement("li");
					var form = document.getElementById('addtask');
					document.getElementById('list').insertBefore(newtask, form);
					newtask.outerHTML = response;
					document.getElementById('newtask').value = "";});
				xhr.open("POST", "https://bizplan.local/addtask");
				xhr.send(data);},
		deleteit: function(event) {
					var id = event.target.parentElement.getAttribute('data-taskid');
					event.target.parentElement.outerHTML = '';
					var listid = document.getElementById('list').dataset.id;
					var jsonData = {id: id, listid: listid};
					var formatted = JSON.stringify(jsonData);
					var xhr = new XMLHttpRequest();
					xhr.open("POST", "https://bizplan.local/deleteit");
					xhr.send(formatted);}
		}
	});
</script>


