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
                var $sondeList = $("#sonde-list");
                var $sectorId = "id_sector_" + sector;
                var $sectors = $(".sectors");
                var $className = "";
                if (data !== null && data.hasOwnProperty("sonde")) {
                    $sondeList.parent().show();
                    $sondeList.empty();
                    $.each(data.sonde, function(k, v) {
                        $sondeList.append("<li class='list-group-item'>"
                            + "<a href='/sonde_details/" + v.id + "'>" + v.name
                            + "</a>"
                            + "</li>"
                        );
                    });
                    $sectors.removeClass().addClass("sectors");
                    $sectors.each(function(){
                        var idElement = $(this).attr('id');
                        if (idElement === $sectorId) {
                            $className = "btn btn-danger";
                        } else {
                            $className = "btn btn-secondary";
                        }
                        $(this).addClass($className);
                    })
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