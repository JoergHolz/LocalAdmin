/*
 | ----------------------------------------------------------------------------------------
 |  L o c a l A d m i n   S E T T I N G S
 |
 |  Documentation: https://github.com/JoergHolz/LocalAdmin
 | ----------------------------------------------------------------------------------------
 |  MIT License (MIT) Copyright (c) 2016 Joerg Holz | https://www.workflow-management.net
 |
 |  Permission is hereby granted, free of charge, to any person obtaining a copy
 |  of this software and associated documentation files (the "Software"), to deal
 |  in the Software without restriction, including without limitation the rights
 |  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 |  copies of the Software, and to permit persons to whom the Software is
 |  furnished to do so, subject to the following conditions:
 |
 |  The above copyright notice and this permission notice shall be included in all
 |  copies or substantial portions of the Software.
 |
 |  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 |  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 |  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 |  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 |  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 |  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 |  SOFTWARE.
 | ----------------------------------------------------------------------------------------
 */

var app = {
    index: function () {
        $(document).ready(app.deviceready);
    },
    deviceready: function () {
        $(window).load(function () {
            $(".preloader").hide();
        });

        var group_states = {};
        if (Cookies.get("group_states")) {
            group_states = JSON.parse(Cookies.get("group_states"));

            jQuery.each(group_states, function (group, state) {
                if (state === "hide") {
                    $("." + group).hide();
                    $("[data-project=" + group + "]").data("display", "hide");
                }
            });
        }

        $(".close-btn").on("click", function () {
            var $this = $(this);
            var project = $this.data("project");
            if ($this.data("display") == "show") {
                $("." + project).hide();
                $this.data("display", "hide");
                group_states[project] = "hide";
            } else {
                $("." + project).show();
                $this.data("display", "show");
                group_states[project] = "show";
            }
            Cookies.set("group_states", group_states, {expires: 100});
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

