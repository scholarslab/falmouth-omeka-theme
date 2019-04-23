/* 
 * @author Scholars' Lab
 *
 */
//TODO: need to set up a proxy host, or get the xref issue taken care of for getFeatureInfo
//OpenLayers.ProxyHost = "/cgi-bin/proxy.cgi?url=";

OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;
OpenLayers.Util.onImageLoadErrorColor = "transparent";
OpenLayers.ImgPath = "http://js.mapbox.com/theme/dark/";

WMS_BASE = 'http://gis.lib.virginia.edu:8080/geoserver/wms';
//WMS_BASE = 'http://lat.lib.virginia.edu:8080/geoserver/wms';
MAX_ZOOM_LEVEL = 21;

var center = new OpenLayers.LonLat(-77.65483, 18.49368); // center on Falmouth
var options = {
    numZoomLevels: MAX_ZOOM_LEVEL,
    projection: new OpenLayers.Projection("EPSG:900913"),
    displayProjection: new OpenLayers.Projection("EPSG:4326"),
    units: 'm',
    maxResolution: 156543.0339,
    maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34)
}



/**
 * Build a CQL string from a list of items
 * @param string items List of items to build cql from
 * @return string cql CQL string for WMS
 */
function make_cql(items, keyword){
    var cql = '';

    // TODO: trim space
    var item_array = items.split(',');

    for( var i = 0; i < item_array.length; i++ ) {
        if( (i + 1) == item_array.length ) {
            cql += keyword + " = '" + item_array[i] + "'";
        } else {
            cql += keyword + " = '" + item_array[i] + "' or ";
        }
    }

    return cql;
}

/**
 * This creates a layer for a district.
 */
function addDistrictLayer(name, style, featureId)
{
    var options = {
        layers: 'Falmouth:Falmouth_Districts',
        transparent: true,
        format: 'image/png8',
        styles: style,
        featureid: featureId
    };
    var layer = new OpenLayers.Layer.WMS(name, WMS_BASE, options, {
        isBaseLayer: false,
        opacity: 0.4
    });

    return layer;
}

/**
 * Attach the 'main' map to a div
 */
function main_map(div, icon_url)
{
    var map = new OpenLayers.Map(div, options);
    var gmap = new OpenLayers.Layer.Google("Google Maps", {sphericalMercator: true, zoomLevels: MAX_ZOOM_LEVEL});
    var gsat = new OpenLayers.Layer.Google("Google Satellite", {type: G_SATELLITE_MAP, sphericalMercator: true, zoomLevels: MAX_ZOOM_LEVEL} );
    var osm = new OpenLayers.Layer.OSM("OpenStreetMap", '', {gutter: 0});

    var blocks = new OpenLayers.Layer.WMS('Block Boundaries', WMS_BASE, 
            {
                'layers': 'Falmouth:Falmouth_Districts',
                transparent: true,
                format: 'image/png8',
                styles: 'polygon_outline_black'
            },
            {
                isBaseLayer: false,
                opacity:0.4
            });

    var infoControls = {
        click: new OpenLayers.Control.WMSGetFeatureInfo({
                    url: WMS_BASE,
                    title: 'Click on feature',
                    layers: [blocks],
                    hover: true,
                    queryVisible: true
               })
    }

    /*
     * /solr-search/results/?ajax=1&solrfacet=id:1238+OR+id:1318+OR+id:1183+OR+id:1315+OR+id:1333+OR+id:1230+OR+id:1216+OR+id:1345+OR+id:1219+OR+id:1219+OR+id:1223+OR+id:1363+OR+id:1323+OR+id:1160+OR+id:1132+OR+id:1047+OR+id:1162+OR+id:1036+OR+id:960+OR+id:1155+OR+id:1148+OR+id:1048+OR+id:953+OR+id:945+OR+id:949+OR+id:964+OR+id:990+OR+id:969+OR+id:878+OR+id:1011+OR+id:987+OR+id:1067+OR+id:1185+OR+id:873+OR+id:1587+OR+id:1569+OR+id:1560+OR+id:867+OR+id:906+OR+id:937
     */
    var buildingSearch = {"docs":[{"id":1132,"title":"Water Square","usage":"Commercial","url":"\/items\/show\/1132","image_url":"\/archive\/square_thumbnails\/b040-s0041_e8c5183f61.jpg","loc":"POINT (-8644237.00211 2095225.44575)"},{"id":1067,"title":"16A Cornwall Street","usage":"Residential","url":"\/items\/show\/1067","image_url":"\/archive\/square_thumbnails\/b031-s0091_ef5df8e353.jpg","loc":"POINT (-8644428.27354 2095365.87019)"},{"id":1048,"title":"11 Market Street","usage":"Residential","url":"\/items\/show\/1048","image_url":"\/archive\/square_thumbnails\/b030-s0051_5069f13c3a.jpg","loc":"POINT (-8644309.75921 2095349.8319)"},{"id":1047,"title":"Baptist Manse","usage":"Religious","url":"\/items\/show\/1047","image_url":"\/archive\/square_thumbnails\/b030-s0041_d4a2d00032.jpg","loc":"POINT (-8644302.53944 2095383.55776)"},{"id":1036,"title":"Falmouth Courthouse","usage":"governmental","url":"\/items\/show\/1036","image_url":"\/archive\/square_thumbnails\/b028-s0021_12be739314.jpg","loc":"POINT (-8644232.29026 2095336.31377)"},{"id":1011,"title":"9 Princess Street","usage":"Residential","url":"\/items\/show\/1011","image_url":"\/archive\/square_thumbnails\/b023-s0201_f53849b2cd.jpg","loc":"POINT (-8644498.88366 2095488.3606)"},{"id":990,"title":"8 Princess Street","usage":"Residential","url":"\/items\/show\/990","image_url":"\/archive\/square_thumbnails\/b022-s0151_cf011e2132.jpg","loc":"POINT (-8644469.02701 2095489.86537)"},{"id":969,"title":"Elizabeth Somerville House ","usage":"Residential","url":"\/items\/show\/969","image_url":"\/archive\/square_thumbnails\/b021-s0081_b3d3dabadb.jpg","loc":"POINT (-8644374.45805 2095435.38146)"},{"id":964,"title":"7 Lower Harbour","usage":"Residential","url":"\/items\/show\/964","image_url":"\/archive\/square_thumbnails\/b021-s0031_2cdebfcbbe.jpg","loc":"POINT (-8644359.5031 2095502.56985)"},{"id":960,"title":"Barrett House","usage":null,"url":"\/items\/show\/960","image_url":"\/archive\/square_thumbnails\/b020-s0161_3f8c23e638.jpg","loc":"POINT (-8644267.89078 2095463.09526)"},{"id":953,"title":"2 Trelawny Street","usage":"governmental","url":"\/items\/show\/953","image_url":"\/archive\/square_thumbnails\/b020-s0091_63eef47145.jpg","loc":"POINT (-8644325.55597 2095420.83457)"},{"id":949,"title":"6 King Street","usage":"Residential","url":"\/items\/show\/949","image_url":"\/archive\/square_thumbnails\/b020-s0051_a8c58dd92b.jpg","loc":"POINT (-8644331.33283 2095462.01457)"},{"id":945,"title":"3 Lower Harbour","usage":"Residential","url":"\/items\/show\/945","image_url":"\/archive\/square_thumbnails\/b020-s0011_b70d85ccea.jpg","loc":"POINT (-8644321.67144 2095488.41961)"},{"id":937,"title":"Unity Church","usage":"Religious","url":"\/items\/show\/937","image_url":"\/archive\/square_thumbnails\/b014-s0011_d37165e9fd.jpg","loc":"POINT (-8644486.45842 2095605.6661)"},{"id":906,"title":"5 Rodney Street","usage":"governmental","url":"\/items\/show\/906","image_url":"\/archive\/square_thumbnails\/b009-s0051_9f68ad22f0.jpg","loc":"POINT (-8644799.17072 2095827.74193)"},{"id":878,"title":"9 King Street","usage":"Residential","url":"\/items\/show\/878","image_url":"\/archive\/square_thumbnails\/b003-s0081_72cd01fc83.jpg","loc":"POINT (-8644304.11621 2095597.14505)"},{"id":873,"title":"Davidson House","usage":"Residential","url":"\/items\/show\/873","image_url":"\/archive\/square_thumbnails\/b003-s0031_b6a652b76f.jpg","loc":"POINT (-8644287.01206 2095663.01593)"},{"id":867,"title":"Fort Balcarres","usage":"Educational","url":"\/items\/show\/867","image_url":"\/archive\/square_thumbnails\/b001-s0021_621fff6d8f.jpg","loc":"POINT (-8644364.3942 2095730.91592)"},{"id":1219,"title":"32 Duke Street","usage":"Residential","url":"\/items\/show\/1219","image_url":"\/archive\/square_thumbnails\/9cf200fc33853d9abe877a116f247b89.jpg","loc":"POINT (-8644598.10488 2095329.25426)"},{"id":1587,"title":"7 Upper Harbour Street","usage":"Commercial","url":"\/items\/show\/1587","loc":"POINT (-8644070.00688 2095064.38594)"},{"id":1569,"title":"Lower Harbour","usage":null,"url":"\/items\/show\/1569","loc":"POINT (-8644086.17321 2095136.80266)"},{"id":1560,"title":"Tharpe House","usage":"Residential","url":"\/items\/show\/1560","loc":"POINT (-8644069.47142 2095174.19918)"},{"id":1363,"title":"St. Peter\u2019s Anglican Church","usage":"Religious","url":"\/items\/show\/1363","image_url":"\/archive\/square_thumbnails\/b056-s0011_b1b37795b1.jpg","loc":"POINT (-8644744.67811 2095322.38615)"},{"id":1345,"title":"31 Duke Street","usage":"Residential","url":"\/items\/show\/1345","image_url":"\/archive\/square_thumbnails\/adf680bd3b1b9ac53fedcf86dacf2765.jpg","loc":"POINT (-8644564.81974 2095297.84389)"},{"id":1333,"title":"Neale Tavern","usage":"Residential","url":"\/items\/show\/1333","image_url":"\/archive\/square_thumbnails\/bd27189392ce9fb571ce9f40e8fd8d59.jpg","loc":"POINT (-8644499.13256 2095269.08664)"},{"id":1323,"title":"William Knibb Baptist Church","usage":"Religious","url":"\/items\/show\/1323","image_url":"\/archive\/square_thumbnails\/5af2775fb6acb78e34015adcac46dead.jpg","loc":"POINT (-8644465.05101 2095199.51992)"},{"id":1318,"title":"19 Duke Street","usage":"Residential","url":"\/items\/show\/1318","image_url":"\/archive\/square_thumbnails\/dd25bf11b782edec282215b7c2fc16c9.jpg","loc":"POINT (-8644464.40699 2095257.04521)"},{"id":1315,"title":"21 Duke Street","usage":"Commercial","url":"\/items\/show\/1315","image_url":"\/archive\/square_thumbnails\/a0b0dfeea60d807b565fcad32e44a75f.jpg","loc":"POINT (-8644478.7976 2095259.70882)"},{"id":1238,"title":"Pitt Street","usage":"Residential","url":"\/items\/show\/1238","image_url":"\/archive\/square_thumbnails\/76c7964b3df84e5727136aa6834f1119.jpg","loc":"POINT (-8644679.46488 2095381.40974)"},{"id":1230,"title":"27 Newton Street","usage":"Residential","url":"\/items\/show\/1230","image_url":"\/archive\/square_thumbnails\/f04f9ff82f730eb3988abc9faea8cb81.jpg","loc":"POINT (-8644631.29506 2095338.07458)"},{"id":1223,"title":"43 Cornwall Street","usage":"Residential","url":"\/items\/show\/1223","image_url":"\/archive\/square_thumbnails\/186b84ecef924a2224959952ec48eea0.jpg","loc":"POINT (-8644656.72417 2095407.9896)"},{"id":1216,"title":"30 Duke Street","usage":"Residential","url":"\/items\/show\/1216","image_url":"\/archive\/square_thumbnails\/442484f848fa67b868531a3604e39b64.jpg","loc":"POINT (-8644562.71667 2095318.18871)"},{"id":1185,"title":"29 Cornwall Street","usage":"Commercial","url":"\/items\/show\/1185","image_url":"\/archive\/square_thumbnails\/b044-s0011_14c3ba420c.jpg","loc":"POINT (-8644520.06654 2095372.85183)"},{"id":1183,"title":"James Hardyman House ","usage":"Residential","url":"\/items\/show\/1183","image_url":"\/archive\/square_thumbnails\/b043-s011map-0_330a7e5542.jpg","loc":"POINT (-8644455.35563 2095279.99509)"},{"id":1162,"title":"23 Market Street","usage":"Commercial","url":"\/items\/show\/1162","image_url":"\/archive\/square_thumbnails\/b042-s0141_5975b4c99a.jpg","loc":"POINT (-8644345.37819 2095245.00693)"},{"id":1160,"title":"21 Market Street","usage":"Residential","url":"\/items\/show\/1160","image_url":"\/archive\/square_thumbnails\/b042-s0121_fd63be0a6d.jpg","loc":"POINT (-8644338.53099 2095264.43577)"},{"id":1155,"title":"Vermont House (Post Office)","usage":"governmental","url":"\/items\/show\/1155","image_url":"\/archive\/square_thumbnails\/b042-s0071_8fc59a4e53.jpg","loc":"POINT (-8644325.84978 2095302.10029)"},{"id":1148,"title":"Water Square","usage":null,"url":"\/items\/show\/1148","image_url":"\/archive\/square_thumbnails\/b041-s0111_ac7a110958.jpg","loc":"POINT (-8644252.87622 2095254.32107)"},{"id":987,"title":"Queen Street","usage":"Residential","url":"\/items\/show\/987","image_url":"\/archive\/square_thumbnails\/b022-s0121_3a50e1c014.jpg","loc":"POINT (-8644423.09078 2095475.83797)"}],"start":0,"count":39}

    var rodney = addDistrictLayer('Rodney Street District', 
                                  'falmouth_med_blue_2',
                                  'Falmouth_Districts.73175881');
    var water = addDistrictLayer('Water Street District', 
                                 'falmouth_lt_blue_2',
                                 'Falmouth_Districts.73175882');
    var wharf = addDistrictLayer('Wharf District',
                                 'falmouth_blue_2',
                                 'Falmouth_Districts.73175885');
    var residential = addDistrictLayer('Residential District',
                                       'falmouth_tan_2',
                                       'Falmouth_Districts.73175883');
    var duke = addDistrictLayer('Duke Street District', 
                                'falmouth_lt_green_2',
                                'Falmouth_Districts.73175884');

    var vectorLayer = new OpenLayers.Layer.Vector("Structures Points");

    var feature = new OpenLayers.Feature.Vector(
            new OpenLayers.Geometry.Point(-77.65474, 18.49528),
            {some: 'data'},
            {externalGraphic: 'images/marker.png', graphicHeight: 21, graphicWidth: 21});

    vectorLayer.addFeatures(feature);
    map.addLayer(vectorLayer);

    var structures = add_search_item(
            buildingSearch.docs, icon_url, 'EPSG:900913');

    map.addLayers([gsat, gmap, osm, blocks, water, rodney, wharf, residential, duke, structures]);

    map.addControl(new OpenLayers.Control.LayerSwitcher({'div':OpenLayers.Util.getElement('layerswitcher'),activeColor:'green'}));
    map.addControl(new OpenLayers.Control.MousePosition());
    map.addControl(new OpenLayers.Control.PanZoomBar());
    map.addControl(new OpenLayers.Control.KeyboardDefaults());
    map.addControl(new OpenLayers.Control.MouseDefaults());

    setDefaultView(map);

    return map;
}

function setHTML(response) {
    document.getElementById('nodelist').innerHTML = repsponse.responseText;
}

/**
 * This centers a map and takes up an extent.
 */
function setDefaultView(map)
{
    var center = new OpenLayers.LonLat(-8644400.47453, 2095381.61275);
    map.setCenter(center, 16);
}

/**
 * Attach a 'browse' map to a div
 */
function browse_map(div)
{
    var map = new OpenLayers.Map(div, options);

    map.addLayer(new OpenLayers.Layer.OSM());
    setDefaultView(map);

    return map;
}

function SearchItem(id, title, url, image_url, loc, usage)
{
    this.id = id;
    this.title = title;
    this.url = url;
    this.image_url = image_url;
    this.usage = usage;
    this.loc = loc;
}

/**
 * Populate the map with items from a list of SearchItem-struct-like objects.
 *
 * items is an array of objects with loc parameters containing WKT MULTIPOINTs.
 * icon is an object defining the icon's properties. It looks for url and size
 *   fields.
 * proj_in is the projection for the input data. This defaults to "EPSG:4326".
 * proj_map is the projection for the map. This defaults to "EPSG:900913".
 * layer is an OpenLayers.Layer.Markers. If this undefined, a new layer is
 * created and returned.
 *
 * Returns the layer the items were added to.
 */
function add_search_item(items, icon, proj_in, proj_map, layer)
{
    var proj_in = (proj_in === undefined) ? 'EPSG:4326' : proj_in;
    var proj_map = (proj_map === undefined) ? 'EPSG:900913' : proj_map;
    var layer = (layer === undefined) ? new OpenLayers.Layer.Markers() : layer;

    var icon_url = icon.url;
    var icon_size = icon.size;
    if (icon_size !== undefined) {
        icon_size = new OpenLayers.Size(icon_size, icon_size);
    }

    var icon = new OpenLayers.Icon(icon_url, icon_size);
    var positions = new Array();
    var parser = new OpenLayers.Format.WKT();

    var ilen = items.length;
    for (var i=0; i<ilen; i++) {
        if (! items[i].loc) {
            continue;
        }

        var point = parser.read(items[i].loc);
        var pos = new OpenLayers.LonLat(point.geometry.x, point.geometry.y);
        positions.push([items[i], pos]);
    }

    if (proj_in != proj_map) {
        var pin = new OpenLayers.Projection(proj_in);
        var pmap = new OpenLayers.Projection(proj_map);
        jQuery.each(positions, function(index, datum) {
            datum[1].transform(pin, pmap);
        });
    }

    jQuery.each(positions, function(index, datum) {
        var marker = new OpenLayers.Marker(datum[1], icon.clone());
        layer.addMarker(marker);
        datum[0].layer = layer;
        datum[0].lonlat = datum[1];
        marker.events.register('click', datum[0], function(ev) {
            display_search_item_info(this, this.layer, this.lonlat);
        });
    });

    return layer;
}

/**
 * This displays a pop-up information box for a search item.
 *
 * item The SearchItem-like object with information about the item.
 * layer The layer to that the item is on.
 * lonlat The position to put the popup.
 */
var falmouthCurrentPopup;
function display_search_item_info(item, layer, lonlat)
{
    if (falmouthCurrentPopup !== undefined && falmouthCurrentPopup != null) {
        falmouthCurrentPopup.hide();
        falmouthCurrentPopup.destroy();
    }

    var astart = '<a href="' + item.url + '">';
    var html = [
        '<div class="popall"><div class="poptitle">',
        astart, item.title, '</a></div>'
        ];
    if (item.image_url) {
        html.push(
            '<div class="popimg">',
            astart, 
            '<img src="', item.image_url, '" /></a></div>'
            );
    }
    html.push(
        '<div class="popuse"><strong>Usage:</strong> ', item.usage, '</div>',
        '</div>'
        );

    var popup = new OpenLayers.Popup(
            null, lonlat, new OpenLayers.Size(160, 275), html.join(''), true
            );
    popup.setBackgroundColor('#F5F5F5');
    popup.setBorder('5px solid #F3E9CD');

    layer.map.addPopup(popup);
    falmouthCurrentPopup = popup;
    return popup;
}



