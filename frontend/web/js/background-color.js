$("[data-background").each(function () {
    $(this).css(
        "background-image",
        "url( " + $(this).attr("data-background") + "  )"
    );
});

// Background image hover change area start here ***
$(".process-block").hover(function () {
    let newBackground = $(this).data("bg");
    $(".process-section .bg-image-box")
        .attr("data-background", newBackground)
        .css("background-image", "url(" + newBackground + ")");
});