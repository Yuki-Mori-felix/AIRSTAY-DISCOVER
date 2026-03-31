// ===============================
// サムネイル付きスライダー
// ===============================
function initSplideSliders() {
	// メインスライダー
	const main = new Splide("#main-carousel", {
		type: "fade", // フェード
		rewind: true, // スライダーの終わりまで行ったら先頭に巻き戻す
		pagination: false, // ページネーション非表示
		arrows: false, // 矢印非表示
		breakpoints: {
			820: {
				pagination: true,
			},
		},
	});

	// サムネイル
	const thumbnails = new Splide("#thumbnail-carousel", {
		perPage: 4, // サムネイル表示枚数
		pagination: false, // ページネーション非表示
		isNavigation: true, // 他のスライダーのナビゲーションとしてクリック可能に
		arrows: false,
		gap: 10,
	});

	main.sync(thumbnails);
	main.mount();
	thumbnails.mount();
}
/* -----------------------------------
  画像アップロード プレビュー表示（複数対応）
----------------------------------- */
function displayPreview() {
	const fileInputs = document.querySelectorAll('input[type="file"]');

	fileInputs.forEach((input) => {
		input.addEventListener("change", function (e) {
			const file = e.target.files[0];
			if (!file) return;

			const previewImg = e.target
				.closest(".form-item")
				.querySelector(".img-preview");

			if (!previewImg) return;

			const reader = new FileReader();
			reader.onload = function (event) {
				previewImg.src = event.target.result;
				previewImg.style.display = "block";
			};
			reader.readAsDataURL(file);
		});
	});
}
/* -----------------------------------
  画像アップロード（ドラッグアンドドロップ）複数対応
----------------------------------- */
function imgDragUpload() {
	const uploadAreas = document.querySelectorAll(".upload-area");

	uploadAreas.forEach((area) => {
		const fileInput = area.querySelector('input[type="file"]');
		const preview = area.closest(".form-item").querySelector(".img-preview");

		if (!fileInput || !preview) return;

		// クリックでファイル選択
		area.addEventListener("click", () => fileInput.click());

		// 通常のファイル選択
		fileInput.addEventListener("change", handleFile);

		// drag over
		area.addEventListener("dragover", (e) => {
			e.preventDefault();
			area.classList.add("dragover");
		});

		// drag leave
		area.addEventListener("dragleave", () => {
			area.classList.remove("dragover");
		});

		// drop
		area.addEventListener("drop", (e) => {
			e.preventDefault();
			area.classList.remove("dragover");

			const file = e.dataTransfer.files[0];
			if (!file) return;

			if (!file.type.startsWith("image/")) {
				alert("画像ファイルのみアップロードできます。");
				return;
			}

			fileInput.files = e.dataTransfer.files;
			showPreview(file);
		});

		function handleFile(e) {
			const file = e.target.files[0];
			if (!file) return;

			if (!file.type.startsWith("image/")) {
				alert("画像ファイルのみアップロードできます。");
				fileInput.value = "";
				return;
			}

			showPreview(file);
		}

		function showPreview(file) {
			const reader = new FileReader();
			reader.onload = (e) => {
				preview.src = e.target.result;
				preview.style.display = "block";
			};
			reader.readAsDataURL(file);
		}
	});
}

document.addEventListener("DOMContentLoaded", () => {
	initSplideSliders();
  displayPreview();
  imgDragUpload();
});
