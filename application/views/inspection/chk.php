<input
	type="file"
	id="photoInput"
	name="vehicle_photos[]"
	accept="image/*"
	capture="environment"
	multiple
	class="form-control" />
<!-- Preview Grid -->
<div id="photoPreview"
	class="grid grid-cols-6 gap-3 mt-3">
</div>
<!-- IMAGE PREVIEW MODAL -->
<div id="imageModal"
	class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50">

	<button onclick="closeImageModal()"
		class="absolute top-4 right-4 text-white text-3xl font-bold">
		✕
	</button>

	<img id="modalImage"
		src=""
		class="max-h-[90vh] max-w-[90vw] rounded shadow-lg">
</div>

<script>
	const photoInput = document.getElementById('photoInput');
	const previewContainer = document.getElementById('photoPreview');
	const imageModal = document.getElementById('imageModal');
	const modalImage = document.getElementById('modalImage');

	let selectedFiles = []; // 🔹 STORE ALL FILES

	photoInput.addEventListener('change', function() {

		const newFiles = Array.from(this.files);

		// 🔒 Max limit check (optional)
		if (selectedFiles.length + newFiles.length > 50) {
			alert('You can upload a maximum of 12 photos.');
			this.value = '';
			return;
		}

		// 🔹 Append new files
		newFiles.forEach(file => selectedFiles.push(file));

		this.value = ''; // 🔥 IMPORTANT: allows selecting same file again

		renderPreview();
	});

	function renderPreview() {
		previewContainer.innerHTML = '';

		selectedFiles.forEach((file, index) => {
			const reader = new FileReader();

			reader.onload = function(e) {
				const wrapper = document.createElement('div');
				wrapper.className = "relative group";

				const thumb = document.createElement('img');
				thumb.src = e.target.result;
				thumb.className = "w-full h-24 object-cover rounded cursor-pointer border hover:scale-105 transition";
				thumb.onclick = () => openImageModal(e.target.result);

				const removeBtn = document.createElement('button');
				removeBtn.type = "button";
				removeBtn.innerHTML = "✕";
				removeBtn.className =
					"absolute top-1 right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded hidden group-hover:block";
				removeBtn.onclick = () => removeImage(index);

				wrapper.appendChild(thumb);
				wrapper.appendChild(removeBtn);
				previewContainer.appendChild(wrapper);
			};

			reader.readAsDataURL(file);
		});
	}

	function removeImage(index) {
		selectedFiles.splice(index, 1);
		renderPreview();
	}

	function openImageModal(src) {
		modalImage.src = src;
		imageModal.classList.remove('hidden');
		imageModal.classList.add('flex');
	}

	function closeImageModal() {
		imageModal.classList.add('hidden');
		imageModal.classList.remove('flex');
	}
</script>
<script>
	/* DELETE SAVED PHOTO (DB IMAGE) */
	function deletePhoto(photoId) {

		if (!confirm('Are you sure you want to delete this photo?')) {
			return;
		}

		fetch("<?= base_url('index.php/inspection/deletePhoto'); ?>", {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					photo_id: photoId
				})
			})
			.then(res => res.json())
			.then(resp => {
				if (resp.success) {
					document.getElementById('photo_' + photoId)?.remove();
				} else {
					alert('Failed to delete photo');
				}
			});
	}
	document.querySelector('form').addEventListener('submit', function() {
		const dataTransfer = new DataTransfer();

		selectedFiles.forEach(file => dataTransfer.items.add(file));

		photoInput.files = dataTransfer.files;
	});
</script>
