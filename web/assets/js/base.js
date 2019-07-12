var SONDE = {
    getSondeBySector: function(sector)
    {
        var self = this;

        $.ajax({
            url: "/sonde_sector",
            dataType: "json",
            type: 'POST',
            data: {'sector': sector},
            success: function (data) {
                var sondeList = $("#sonde-list");
                if (data !== null && data.hasOwnProperty("sonde")) {
                    sondeList.parent().show();
                    sondeList.empty();
                    $.each(data.sonde, function(k, v) {
                        sondeList.append("<li class='list-group-item'>"
                            + "<a href='/sonde_details/" + v.id + "'>" + v.name
                            + "</a>"
                            + "</li>"
                        );
                    });
                } else {
                    alert(data.message);
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    },

    init: function(
        selectedSector
    ){
        this.config = {
            selectedSector: selectedSector
        };
        this.getSondeBySector(this.config.selectedSector);
    }
};
SONDE.init(
    selectedSector
);