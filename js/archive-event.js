document.addEventListener("DOMContentLoaded", () => {
	initFilterModal();
});

// ===============================
// イベント一覧ページ Filter Modal
// ===============================
function initFilterModal() {
	const filterToggleButton = document.querySelector(".filter-toggle-button");
	const filterModal = document.querySelector(".filter-modal");
	const filterCloseButton = document.querySelector(".filter-close-button");
	const filterModalOverlay = document.querySelector(".filter-modal-overlay");
	const filterModalContent = document.querySelector(".filter-modal-content");

	if (!filterModal) return;

	// モーダルを開く
	if (filterToggleButton) {
		filterToggleButton.addEventListener("click", function () {
			filterModal.style.display = "block";
			document.body.style.overflow = "hidden"; // 背景スクロール防止
		});
	}

	// モーダルを閉じる（×ボタン）
	if (filterCloseButton) {
		filterCloseButton.addEventListener("click", function () {
			filterModal.style.display = "none";
			document.body.style.overflow = "";
		});
	}

	// モーダル内クリックは閉じない
	if (filterModalContent) {
		filterModalContent.addEventListener("click", function (e) {
			e.stopPropagation();
		});
	}

	// オーバーレイクリックで閉じる
	if (filterModalOverlay) {
		filterModalOverlay.addEventListener("click", function () {
			filterModal.style.display = "none";
			document.body.style.overflow = "";
		});
	}

	// ESCキーで閉じる
	document.addEventListener("keydown", function (e) {
		if (e.key === "Escape" && filterModal.style.display === "block") {
			filterModal.style.display = "none";
			document.body.style.overflow = "";
		}
	});
}
