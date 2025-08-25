var elem=document.querySelector(".grid-contain");
var msnry=new Masonry(elem, {
    itemSelector:".grid-items",
    columnWidth:".imgr",
    gutter: 5,
    isFitWidth:true
});