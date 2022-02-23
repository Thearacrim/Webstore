// $(function () {
//   const $addCart = $(".btn-add-to-cart");
//   $addCart.click((ev) => {
//     ev.preventDefault();
//     const $this = $(ev.target);
//     const id = $this.closest(".product-item").data("key");
//     console.log(id);
//     $.ajax({
//       type: "post",
//       url: $this.attr("href"),
//       data: { id: id },
//       function(data) {
//         console.log("form submit output");
//         console.log(data);
//       },
//     });
//   });
// });
