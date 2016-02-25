var app = {
    index: function () {
        $(document).ready(app.deviceready);
    },
    deviceready: function () {
        $(window).load(function () {
            $(".preloader").hide();
        });

        $("a[href='#']").click(function (e) {
            e.preventDefault();
        });

        $("[data-toggle='popover']").popover({
            html: true,
            trigger: "click",
            container: "body"
        });

        $("body").on("click", function (e) {
            $("[data-toggle='popover']").each(function () {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $(".popover").
                        has(e.target).length === 0) {
                    $(this).popover("hide");
                }
            });
        });

        if (show_tooltips === true) {
            $("[data-toggle='tooltip'], .livepreview").tooltip({
                placement: "bottom",
                container: "body"
            });
        }

        $(window).resize(function () {
            floating();
        });

        floating();

        function floating() {
            if ($(window).width() < button_groups_in_two_rows_at) {
                $(".panel-body .remote").each(function () {
                    var $this = $(this);
                    if (!$this.hasClass("no-right")) {
                        $this.removeClass("pull-right").addClass("pull-left");
                    }
                });
                $(".group-title").addClass("text-overflow");
                $(".btn-group.dir").css("margin-top", "0");
            } else {
                $(".panel-body .remote").each(function () {
                    var $this = $(this);
                    if (!$this.hasClass("no-right")) {
                        $this.removeClass("pull-left").addClass("pull-right");
                    }
                });
                $(".group-title").removeClass("text-overflow");
                $(".btn-group.dir").css("margin-top", "20px");
            }
        }

        $(".shell").on("click", function () {
            var $this = $(this);
            $.ajax({
                url: "?c=localadmin&m=exec_shell&uuid=" + $this.data("uuid")
            }).done(function (data) {
                var out = "<p><small>" + new Date() + "</small></p>";
                $(".shelloutput").append(out + data);
            });
        });

        if (show_public_ip === true) {
            $.getJSON("https://api.ipify.org?format=jsonp&callback=?",
                function (json) {
                    $("#public_ip").text(json.ip);
                }
            );
        }
    }
};

