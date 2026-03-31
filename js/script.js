document.addEventListener("DOMContentLoaded", () => {
	initSpMenu();
	initHeaderSearch();
	downContents();
	displayPreview();
	imgDragUpload();
	switchDisplayPasswor();
});

// ===============================
// SPメニューボタン開閉
// ===============================
function initSpMenu() {
	const spMenuButton = document.querySelector(".sp-menu-button");
	const spNav = document.querySelector(".sp-nav");

	if (spMenuButton && spNav) {
		spMenuButton.addEventListener("click", function (e) {
			e.preventDefault();

			this.classList.toggle("is-act");
			spNav.classList.toggle("is-act");
		});
	}
}
// ===============================
// Search メニュー開閉
// ===============================
function initHeaderSearch() {
	const btn = document.querySelector(".header-menu-search-button");
	const box = document.querySelector(".header-menu-search");

	if (btn && box) {
		btn.addEventListener("click", function (e) {
			e.preventDefault();

			// is-act の付け外し
			this.classList.toggle("is-act");

			// フェードイン / フェードアウト
			if (box.classList.contains("is-show")) {
				fadeOut(box);
			} else {
				fadeIn(box);
			}
		});
	}

	// ▼ フェードイン
	function fadeIn(el) {
		el.style.display = "block";
		el.style.opacity = 0;
		el.classList.add("is-show");

		let op = 0;
		const timer = setInterval(() => {
			if (op >= 1) {
				clearInterval(timer);
			}
			el.style.opacity = op;
			op += 0.1;
		}, 20);
	}

	// ▼ フェードアウト
	function fadeOut(el) {
		let op = 1;
		const timer = setInterval(() => {
			if (op <= 0) {
				clearInterval(timer);
				el.style.display = "none";
				el.classList.remove("is-show");
			}
			el.style.opacity = op;
			op -= 0.1;
		}, 20);
	}
}
/* -----------------------------------
  ヘッダーの高さ分だけコンテンツを下げる
----------------------------------- */
function downContents() {
	// トップページでは実行しない
	if (document.body.classList.contains("home")) {
		return;
	}
	const header = document.getElementById("header");
	const height = header.offsetHeight;
	document.querySelector("main").style.paddingTop = height + "px";
}
/* -----------------------------------
  画像のアップロードでプレビューを表示
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
  画像のアップロード（ドラッグアンドドロップ）
----------------------------------- */
function imgDragUpload() {
	const uploadArea = document.getElementById("upload-area");
	const fileInput = document.getElementById("file-input");
	const preview = document.getElementById("preview");

	if (!fileInput) return;
	uploadArea.addEventListener("click", () => fileInput.click());
	fileInput.addEventListener("change", handleFile);

	uploadArea.addEventListener("dragover", (e) => {
		e.preventDefault();
		uploadArea.classList.add("dragover");
	});

	uploadArea.addEventListener("dragleave", () => {
		uploadArea.classList.remove("dragover");
	});

	uploadArea.addEventListener("drop", (e) => {
		e.preventDefault();
		uploadArea.classList.remove("dragover");

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
}
/* -----------------------------------
  ログイン画面パスワード表示切替ボタン
----------------------------------- */
function switchDisplayPasswor() {
	const passwordField = document.getElementById("password-field");
	const toggleBtn = document.getElementById("toggle-password");

	if (!toggleBtn) return;
	const iconEye = toggleBtn.querySelector(".fa-eye");
	const iconEyeSlash = toggleBtn.querySelector(".fa-eye-slash");

	toggleBtn.addEventListener("click", function () {
		const isHidden = passwordField.type === "password";

		// パスワード表示切り替え
		passwordField.type = isHidden ? "text" : "password";

		// アイコン切り替え
		iconEye.style.display = isHidden ? "none" : "block";
		iconEyeSlash.style.display = isHidden ? "block" : "none";
	});
}
