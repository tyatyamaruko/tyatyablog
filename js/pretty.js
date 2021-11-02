$(function() {
    let pre = $("pre");
    pre.addClass("prettyprint");
    pre.addClass("prettyprinted");
    let code = $("code");
    code.addClass("prettyprint");
});

window.addEventListener("load", function(event) {
    PR.prettyPrint()
});