<style>
	.row-selected {
		background-color: #ffe5e5;
		/* light red */
	}
</style>
<div class="p-6 bg-white rounded shadow">
	<h2 class="text-xl font-bold mb-4">Admin Data Manager</h2>

	<!-- Table Input -->
	<input type="text" id="table_name" placeholder="Enter table name"
		class="border p-2 rounded w-64">

	<button onclick="loadTable()" class="bg-blue-500 text-white px-4 py-2 rounded">
		Load
	</button>
	<button onclick="deleteSelected()"
		class="bg-red-500 text-white px-4 py-2 rounded mt-2">
		Delete Selected
	</button>

	<input type="text" id="search_box" placeholder="Search..."
		class="border p-2 rounded w-64 ml-2"
		onkeyup="loadTable()">

	<table border="1" class="mt-4 w-full" id="data_table">
		<thead></thead>
		<tbody></tbody>
	</table>
</div>

<script>
	function toggleAll(source) {
		document.querySelectorAll('.row_checkbox').forEach(cb => {
			cb.checked = source.checked;

			let row = cb.closest('tr');
			if (source.checked) {
				row.classList.add('row-selected');
			} else {
				row.classList.remove('row-selected');
			}
		});
	}

	function deleteSelected() {
		let table = document.getElementById('table_name').value;
		let selected = [];

		document.querySelectorAll('.row_checkbox:checked').forEach(cb => {
			selected.push(cb.value);
		});

		if (selected.length === 0) {
			alert("No rows selected");
			return;
		}

		if (!confirm("Delete selected records?")) return;

		fetch("<?= base_url('index.php/Admintools/delete_multiple') ?>", {
				method: "POST",
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: `table=${table}&ids=${selected.join(',')}`
			})
			.then(res => res.json())
			.then(res => {
				alert(res.msg || "Deleted");
				loadTable();
			});
	}

	function loadTable() {
		let table = document.getElementById('table_name').value;
		let search = document.getElementById('search_box').value;

		fetch("<?= base_url('index.php/Admintools/get_table_data') ?>", {
				method: "POST",
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: "table=" + table + "&search=" + encodeURIComponent(search)
			})
			.then(res => res.json())
			.then(data => {

				let thead = document.querySelector("#data_table thead");
				let tbody = document.querySelector("#data_table tbody");

				thead.innerHTML = "";
				tbody.innerHTML = "";

				if (data.length === 0) {
					thead.innerHTML = "<tr><th>No data found</th></tr>";
					return;
				}

				// headers
				let headers = Object.keys(data[0]);
				let headerRow = "<tr>";

				// checkbox column
				headerRow += `<th>
			<input type="checkbox" onclick="toggleAll(this)">
		</th>`;

				// action column
				headerRow += "<th>Action</th>";

				// dynamic columns
				headers.forEach(h => headerRow += "<th>" + h + "</th>");
				headerRow += "</tr>";

				thead.innerHTML = headerRow;

				// rows
				data.forEach(row => {
					let tr = "<tr>";

					let pk = headers[0]; // assume first column is PK

					tr += `<td>
				<input type="checkbox" class="row_checkbox" value="${row[pk]}" onchange="highlightRow(this)">
			</td>`;

					tr += `<td>
				<button onclick="deleteRow('${table}', '${pk}', '${row[pk]}')" 
				style="color:red;">Delete</button>
			</td>`;

					headers.forEach(h => {
						tr += "<td>" + (row[h] ?? '') + "</td>";
					});

					tr += "</tr>";
					tbody.innerHTML += tr;
				});
			})
			.catch(err => {
				console.error("Error loading table:", err);
			});
	}

	function loadTable12() {
		let table = document.getElementById('table_name').value;

		fetch("<?= base_url('index.php/Admintools/get_table_data') ?>", {
				method: "POST",
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: "table=" + table
			})
			.then(res => res.json())
			.then(data => {

				let thead = document.querySelector("#data_table thead");
				let tbody = document.querySelector("#data_table tbody");

				thead.innerHTML = "";
				tbody.innerHTML = "";

				if (data.length === 0) return;

				// headers
				let headers = Object.keys(data[0]);
				let headerRow = "<tr>";


				headerRow += `<th>
					<input type="checkbox" onclick="toggleAll(this)">
				</th>`;



				headerRow += "<th>Action</th>"; // ✅ FIRST column

				headers.forEach(h => headerRow += "<th>" + h + "</th>");
				headerRow += "</tr>";
				thead.innerHTML = headerRow;

				// rows
				data.forEach(row => {
					let tr = "<tr>";

					let pk = headers[0]; // assume first column is PK
					tr += `<td>
						<input type="checkbox" class="row_checkbox" value="${row[pk]}" onchange="highlightRow(this)">
					</td>`;

					// ✅ FIRST column button
					tr += `<td>
						<button onclick="deleteRow('${table}', '${pk}', '${row[pk]}')" 
						style="color:red;">Delete</button>
					</td>`;

					// other columns
					headers.forEach(h => tr += "<td>" + row[h] + "</td>");

					tr += "</tr>";
					tbody.innerHTML += tr;
				});
			});
		// .then(data => {

		//     let thead = document.querySelector("#data_table thead");
		//     let tbody = document.querySelector("#data_table tbody");

		//     thead.innerHTML = "";
		//     tbody.innerHTML = "";

		//     if (data.length === 0) return;


		//     let headers = Object.keys(data[0]);
		//     let headerRow = "<tr>";
		//     headers.forEach(h => headerRow += "<th>" + h + "</th>");
		//     headerRow += "<th>Action</th></tr>";
		//     thead.innerHTML = headerRow;


		//     data.forEach(row => {
		//         let tr = "<tr>";
		//         headers.forEach(h => tr += "<td>" + row[h] + "</td>");

		//         let pk = headers[0]; 
		//         tr += `<td>
		//             <button onclick="deleteRow('${table}', '${pk}', '${row[pk]}')" 
		//             style="color:red;">Delete</button>
		//         </td>`;

		//         tr += "</tr>";
		//         tbody.innerHTML += tr;
		//     });
		// });
	}

	function deleteRow(table, pk, id) {
		if (!confirm("Are you sure?")) return;

		fetch("<?= base_url('index.php/Admintools/delete_record') ?>", {
				method: "POST",
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: `table=${table}&pk=${pk}&id=${id}`
			})
			.then(res => res.json())
			.then(res => {
				alert(res.msg || "Deleted");
				loadTable();
			});
	}

	function highlightRow(checkbox) {
		let row = checkbox.closest('tr');

		if (checkbox.checked) {
			row.classList.add('row-selected');
		} else {
			row.classList.remove('row-selected');
		}
	}
</script>
