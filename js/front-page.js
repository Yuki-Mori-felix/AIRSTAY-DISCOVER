document.addEventListener("DOMContentLoaded", () => {
	mv_slider();
	event_slider();
});
/* -----------------------------------
  TOPページ MVスライダー
----------------------------------- */
function mv_slider() {
	var splide = new Splide(".splide-mv", {
		type: "fade",
		rewind: true,
		autoplay: true,
		interval: 5000, // 3秒ごと
		speed: 3000, // フェードに5秒
		pagination: false,
		pauseOnHover: false,
		pauseOnFocus: false,
		arrows: false,
		height: "600px",
		breakpoints: {
			820: {
				height: "420px",
			},
		},
	});
	splide.mount();
}
/* -----------------------------------
  TOPページ イベントスライダー
----------------------------------- */
function event_slider() {
	var splide = new Splide(".splide-event", {
		type: "loop",
		perPage: 2,
		perMove: 1,
		gap: 40,
		speed: 1000, // フェードに1秒
		arrows: true,
		rewind: true, // 最初のスライドへ戻す
		autoHeight: true,
		pagination: false,
		width: "1100px",
		autoHeight: true,
		breakpoints: {
			1240: {
				width: "520px",
				perPage: 1,
				focus: "center",
			},
			600: {
				width: "82%",
			},
		},
	});
	splide.mount();
}
