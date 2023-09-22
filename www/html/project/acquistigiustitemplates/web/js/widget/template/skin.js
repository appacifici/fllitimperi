window.mobileCheck = function () {
    let check = false;
    (function (a) { if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true; })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
};

var s = document.createElement('script');
s.type = 'text/javascript';
s.async = true;
s.src = '//www.googletagservices.com/tag/js/gpt.js';
var sc = document.getElementsByTagName('script')[0];
sc.parentNode.insertBefore(s, sc);

var p = document.createElement('script');
p.type = 'text/javascript';
p.async = true;
p.src = 'https://unifiedads.magellanotech.it/scripts/prebid.js';
var sp = document.getElementsByTagName('script')[0];
sp.parentNode.insertBefore(p, sp);
var nocmp = false;

//Definizione dimensioni
var sizeMapping_global = {
    'MG_MH_ALL': [
        { browser: [992, 0], ad_sizes: [[990, 250], [970, 250], [970, 90], [728, 90], [1, 1]] },
        { browser: [768, 0], ad_sizes: [[728, 90], [1, 1]] },
        { browser: [468, 0], ad_sizes: [[468, 60], [1, 1]] },
        { browser: [320, 0], ad_sizes: [[320, 50], [320, 100], [1, 1]] }
    ],
    'MG_MH_ALL_HB': [
        { minViewPort: [992, 0], sizes: [[990, 250], [970, 250], [970, 90], [728, 90]] },
        { minViewPort: [768, 0], sizes: [[728, 90]] },
        { minViewPort: [468, 0], sizes: [[468, 60]] },
        { minViewPort: [320, 0], sizes: [[320, 50], [320, 100]] }
    ],
    'MG_MH_MIN': [
        { browser: [992, 0], ad_sizes: [[728, 90]] },
        { browser: [768, 0], ad_sizes: [[728, 90], [468, 60]] },
        { browser: [320, 0], ad_sizes: [[320, 50], [320, 100]] }
    ],
    'MG_MH_MIN_HB': [
        { minViewPort: [992, 0], sizes: [[728, 90]] },
        { minViewPort: [768, 0], sizes: [[728, 90]] },
        { minViewPort: [468, 0], sizes: [[468, 60]] },
        { minViewPort: [320, 0], sizes: [[320, 50], [320, 100]] }
    ],
    'MG_MH_MIN_MIN': [
        { browser: [992, 0], ad_sizes: [[728, 90]] },
        { browser: [768, 0], ad_sizes: [[728, 90], [468, 60]] },
        { browser: [320, 0], ad_sizes: [[320, 50]] }
    ],
    'MG_MH_MIN_MIN_HB': [
        { minViewPort: [992, 0], sizes: [[728, 90]] },
        { minViewPort: [768, 0], sizes: [[728, 90]] },
        { minViewPort: [468, 0], sizes: [[468, 60]] },
        { minViewPort: [320, 0], sizes: [[320, 50]] }
    ],
    'MG_ARTICLE': [
        { browser: [992, 0], ad_sizes: [[300, 250], [336, 280], [1, 1]] },
        { browser: [768, 0], ad_sizes: [[300, 250], [336, 280], [1, 1]] },
        { browser: [320, 0], ad_sizes: [[300, 250], [336, 280], [1, 1]] },
    ],
    'MG_ARTICLE_L': [
        { browser: [992, 0], ad_sizes: [[300, 250], [336, 280], [300, 600], [1, 1]] },
        { browser: [768, 0], ad_sizes: [[300, 250], [336, 280], [300, 600], [1, 1]] },
        { browser: [320, 0], ad_sizes: [[300, 250], [336, 280], [300, 600], [1, 1]] },
    ],
    'MG_ARTICLE_L_HB': [
        { minViewPort: [992, 0], sizes: [[300, 250], [336, 280], [300, 600], [1, 1]] },
        { minViewPort: [768, 0], sizes: [[300, 250], [336, 280], [300, 600], [1, 1]] },
        { minViewPort: [320, 0], sizes: [[300, 250], [336, 280], [300, 600], [1, 1]] },
    ],
    'MG_ARTICLE_HB': [
        { minViewPort: [992, 0], sizes: [[300, 250], [336, 280], [1, 1]] },
        { minViewPort: [768, 0], sizes: [[300, 250], [336, 280], [1, 1]] },
        { minViewPort: [320, 0], sizes: [[300, 250], [336, 280], [1, 1]] }
    ],
    'MG_ARTICLE_MIN': [
        { browser: [992, 0], ad_sizes: [[300, 250]] },
        { browser: [768, 0], ad_sizes: [[300, 250]] },
        { browser: [320, 0], ad_sizes: [[300, 250]] }
    ],
    'MG_ARTICLE_MIN_HB': [
        { minViewPort: [992, 0], sizes: [[300, 250]] },
        { minViewPort: [768, 0], sizes: [[300, 250]] },
        { minViewPort: [320, 0], sizes: [[300, 250]] }
    ],
    'MG_ARTICLE_300_250': [
        { browser: [992, 0], ad_sizes: [[300, 250]] },
        { browser: [768, 0], ad_sizes: [[300, 250]] },
        { browser: [320, 0], ad_sizes: [[300, 250]] }
    ],
    'MG_SDB_600': [
        { browser: [992, 0], ad_sizes: [[300, 600]] },
        { browser: [768, 0], ad_sizes: [[300, 600]] },
        { browser: [320, 0], ad_sizes: [[300, 250], [336, 280]] }
    ],
    'MG_SDB_600_HB': [
        { minViewPort: [992, 0], sizes: [[300, 600], [1, 1]] },
        { minViewPort: [768, 0], sizes: [[300, 600], [1, 1]] },
        { minViewPort: [320, 0], sizes: [[336, 280], [300, 250], [1, 1]] }
    ],
    'MG_SB': [
        { browser: [992, 0], ad_sizes: [[336, 280], [300, 250], [300, 600], [1, 1]] },
        { browser: [768, 0], ad_sizes: [[336, 280], [300, 250], [300, 600], [1, 1]] },
        { browser: [320, 0], ad_sizes: [[300, 250], [336, 280], [1, 1]] },
    ],
    'MG_SB_HB': [
        { minViewPort: [992, 0], sizes: [[336, 280], [300, 250], [300, 600], [1, 1]] },
        { minViewPort: [768, 0], sizes: [[336, 280], [300, 250], [300, 600], [1, 1]] },
        { minViewPort: [320, 0], sizes: [[336, 280], [300, 250], [1, 1]] }
    ],
    'MG_SDB_MIN': [
        { minViewPort: [992, 0], sizes: [[300, 250], [1, 1]] },
        { minViewPort: [768, 0], sizes: [[300, 250], [1, 1]] },
        { minViewPort: [320, 0], sizes: [[336, 280], [300, 250], [1, 1]] }
    ],
    'MG_SKIN': [
        { browser: [992, 0], ad_sizes: [[1, 1]] },
        { browser: [768, 0], ad_sizes: [] },
        { browser: [320, 0], ad_sizes: [] }
    ],
};

var adUnits_HB = [];


var PREBID_TIMEOUT = 1700;
var FAILSAFE_TIMEOUT = 3000;

//Recupero posizionamento in pagina e switch per host
adCollection = jQuery('.mg-adv-controller');
teads_placement_id = 0;
teads_page_id = 0;
seedtag_publisherid = '';

switch (location.host) {

    case 'www.youbee.it':
        teads_placement_id = 172844;
        teads_page_id = 158300;
        break;
    case 'www.passionetecnologica.it':
        teads_placement_id = 171172;
        teads_page_id = 156664;
        break;
    case 'www.lineadiretta24.it':
        teads_placement_id = 175426;
        teads_page_id = 160820;
        seedtag_publisherid = '1853-0252-01';
        break;
    case 'www.fortementein.com':
        teads_placement_id = 172827;
        teads_page_id = 158283;
        break;
    case 'www.solomotori.it':
        teads_placement_id = 172829;
        teads_page_id = 158285;
        seedtag_publisherid = '5726-7212-01';
        break;
    case 'www.giornalemotori.it':
        teads_placement_id = 172831;
        teads_page_id = 158287;
        break;
    case 'www.motorzoom.it':
        teads_placement_id = 172828;
        teads_page_id = 158284;
        break;
    case 'www.solofinanza.it':
        teads_placement_id = 172836;
        teads_page_id = 158292;
        break;
    case 'www.irenemilito.it':
        teads_placement_id = 176392;
        teads_page_id = 161722;
        break;
    case 'www.newscinema.it':
        teads_placement_id = 176389;
        teads_page_id = 161719;
        seedtag_publisherid = '9223-4462-01';
        break;
    case 'www.ilromanista.it':
        teads_placement_id = 175423;
        teads_page_id = 160817;
        seedtag_publisherid = '9787-4987-01';
        break;
    case 'www.solospettacolo.it':
        teads_placement_id = 172834;
        teads_page_id = 158290;
        seedtag_publisherid = '6043-0651-01';
        break;
    default:

}

adCollection.each(function () {


    var jQueryadUnit = jQuery(this);

    if (jQueryadUnit.data('mapping').includes('MG_SB') && mobileCheck()) {
        return true;
    }

    //console.log(jQueryadUnit);
    var dimensions = [],
        dimensionsData = jQueryadUnit.data('dimensions');
    if (dimensionsData) {
        var dimensionGroups = dimensionsData.split(',');
        jQuery.each(dimensionGroups, function (k, v) {
            var dimensionSet = v.split('x');
            if (dimensionSet[0] == 'fluid') {
                //console.log(dimensionSet);
                dimensions.push([dimensionSet[0]]);
            } else {
                dimensions.push([parseInt(dimensionSet[0], 10), parseInt(dimensionSet[1], 10)]);
            }

        });
    } else {
        dimensions.push([jQueryadUnit.width(), jQueryadUnit.height()]);
    }

    var adUnitName = jQueryadUnit.data('slot');

    googletag.cmd.push(function () {

        var googleAdUnit;

        // Create the ad - out of page or normal

        if (jQueryadUnit.data('mapping').includes('MG_MH_ALL') && mobileCheck()) {
            googleAdUnit = window.googletag.defineOutOfPageSlot('/' + '22820207193' + '/' + adUnitName, window.googletag.enums.OutOfPageFormat.TOP_ANCHOR);
        } else {
            googleAdUnit = window.googletag.defineSlot('/' + '22820207193' + '/' + adUnitName, dimensions, jQueryadUnit.attr('id'));
        }


        googleAdUnit = googleAdUnit.addService(googletag.pubads());

        var mapping = jQueryadUnit.data('mp');

        //Se esiste la definizione del posizionamento aggiunge la size al banner google
        if (mapping && sizeMapping_global[mapping]) {
            // Convert verbose to DFP format
            var map = googletag.sizeMapping();
            jQuery.each(sizeMapping_global[mapping], function (k, v) {
                map.addSize(v.browser, v.ad_sizes);
            });
            googleAdUnit.defineSizeMapping(map.build());
        }
    });





    //TODO: questa è la configurazione base dell'oggetto che poi viene esteso negli if sottostanti?
    var u_hb = {
        //code: '/' + '22820207193' + '/' + adUnitName,
        code: jQueryadUnit.attr('id'),
        mediaTypes: {
            banner: {
                sizeConfig: sizeMapping_global[jQueryadUnit.data('mapping') + '_HB']
            }
        },
        bids: [{
            bidder: 'teads',
            params: {
                placementId: teads_placement_id,
                pageId: teads_page_id
            }
        },
        {
            bidder: 'criteo',
            params: {
                networkId: 11596
            }
        },
        {
            bidder: 'pubmatic',
            params: {
                publisherId: '163324'
            }
        }
        ]
    };

    if (jQueryadUnit.attr('placementid-adasta')) {
        u_hb.bids.push({
            bidder: 'adasta',
            params: {
                placementId: jQueryadUnit.attr('placementid-adasta')
            }
        });
    }

    if (jQueryadUnit.attr('placementid-seedtag')) {
        u_hb.bids.push({
            bidder: 'seedtag',
            params: {
                adUnitId: jQueryadUnit.attr('placementid-seedtag'),
                publisherId: seedtag_publisherid,
                placement: 'inArticle'
            }
        });
    }


    adUnits_HB.push(u_hb);

});




googletag.cmd.push(function () {
    googletag.pubads().disableInitialLoad();
    googletag.pubads().enableSingleRequest();
    googletag.pubads().enableLazyLoad({
        // Fetch slots within 2 viewports.
        fetchMarginPercent: 100,
        // Render slots within 1 viewports.
        renderMarginPercent: 100,
        // Double the above values on mobile, where viewports are smaller
        // and users tend to scroll faster.
        mobileScaling: 2.0
    });

    //googletag.pubads().enableLazyLoad();

    googletag.pubads().addEventListener('slotRequested', function (event) {
        console.log('google_fetched : ' + event.slot.getSlotElementId() + ' fetched');
    });

    googletag.pubads().addEventListener('slotOnload', function (event) {
        console.log('google_rendered : ' + event.slot.getSlotElementId() + ' rendered');
    });

    googletag.enableServices();
});


//load the apstag.js library
!function (a9, a, p, s, t, A, g) { if (a[a9]) return; function q(c, r) { a[a9]._Q.push([c, r]) } a[a9] = { init: function () { q("i", arguments) }, fetchBids: function () { q("f", arguments) }, setDisplayBids: function () { }, targetingKeys: function () { return [] }, _Q: [] }; A = p.createElement(s); A.async = !0; A.src = t; g = p.getElementsByTagName(s)[0]; g.parentNode.insertBefore(A, g) }("apstag", window, document, "script", "//c.amazon-adsystem.com/aax2/apstag.js");

apstag.init({
    pubID: '1ff2e623-a901-438b-b4ac-a92c9e6374f0',
    adServer: 'googletag',
    simplerGPT: true
});

//TODO  pbjs??? 
var pbjs = pbjs || {};
pbjs.que = pbjs.que || [];


pbjs.que.push(function () {
    pbjs.addAdUnits(adUnits_HB);
});



function executeParallelAuctionAlongsidePrebid() {
    console.log("==========>", location.host);

    var _mgid_flag = false;
    var _mgid_url = '';
    var _viralize = false;
    var _teads = '';
    var _adsense = false;
    var _adkaora = false;
    var _adkaora_link = '';
    var _vidoomy = false;
    var _vidoomy_link = '';
    var _natid = '';
    var _vdp = false;
    var _seedtag = '';
    var _fluid = false;
    var _sky_display = false;

    switch (location.host) {

        case 'www.passionetecnologica.it':
            _mgid_flag = true;
            _adsense = true;
            _viralize = true;
            _adkaora = true;
            _adkaora_link = 'https://cdn.adkaora.space/magellano/passionetecnologica/prod/adk-init.js';
            _teads = '155083';
            _mgid_url = 'https://jsc.mgid.com/p/a/passionetecnologica.it.1351417.js';
            _natid = '63efba20d97cddbc3d9657dc';
            _seedtag = '1824-7479-01';
            break;

        case 'www.motorzoom.it':
            _adsense = true;
            _viralize = true;
            _teads = '155072';
            _adkaora = true;
            _adkaora_link = 'https://cdn.adkaora.space/magellano/motorzoom/prod/adk-init.js';
            _mgid_flag = true;
            _mgid_url = 'https://jsc.mgid.com/m/o/motorzoom.it.1348509.js';
            _seedtag = '7682-2059-01';
            break;

        case 'www.solomotori.it':
            _adsense = true;
            //_vidoomy = true;
            //_vidoomy_link = 'https://ads.vidoomy.com/solomotoriit_21161.js';
            _mgid_flag = true;
            _viralize = false;
            _fluid = true;
            //_teads = '155079';
            _mgid_url = 'https://jsc.mgid.com/s/o/solomotori.it.1352433.js';
            _adkaora = true;
            _adkaora_link = 'https://cdn.adkaora.space/magellano/solomotori/prod/adk-init.js';
            _natid = '63efbe72d97cddbc3d965860';
            _seedtag = '5726-7212-01';
            _sky_display = true;
            break;

        case 'www.giornalemotori.it':
            _adsense = true;
            _mgid_flag = true;
            _viralize = true;
            _teads = '155227';
            _mgid_url = 'https://jsc.mgid.com/g/i/giornalemotori.it.1359845.js';
            _adkaora = true;
            _seedtag = '0906-8463-01';
            _adkaora_link = 'https://cdn.adkaora.space/magellano/giornalemotori/prod/adk-init.js';
            break;

        case 'www.youbee.it':
            _adsense = true;
            _viralize = false;
            _vidoomy = true;
            _vidoomy_link = 'https://ads.vidoomy.com/youbeeit_21163.js';
            _teads = '157689';
            _mgid_flag = true;
            _mgid_url = 'https://jsc.mgid.com/y/o/youbee.it.1376975.js';
            _adkaora = true;
            _adkaora_link = 'https://cdn.adkaora.space/magellano/youbee/prod/adk-init.js';
            _natid = '63efc596d97cddbc3d965e26';
            _seedtag = '0100-3916-01';
            break;

        case 'www.lineadiretta24.it':

            if (nocmp) {
                _adsense = false;
                _viralize = false;
                _teads = '160822';
                //_fluid = false;
                _mgid_flag = true;
                _mgid_url = 'https://jsc.mgid.com/m/a/magellanotech.lineadiretta24.it.1392466.js';
                _adkaora = true;
                _adkaora_link = 'https://cdn.adkaora.space/magellano/lineadiretta24/prod/adk-init.js';
                _natid = '63efc5b8d97cddbc3d965e3a';
                _seedtag = '0007-9199-01';
                _vdp = false;

            }
            else {
                _adsense = true;
                _viralize = false;
                //_teads = '160822';
                _fluid = true;
                _mgid_flag = true;
                _mgid_url = 'https://jsc.mgid.com/m/a/magellanotech.lineadiretta24.it.1392466.js';
                _adkaora = true;
                _adkaora_link = 'https://cdn.adkaora.space/magellano/lineadiretta24/prod/adk-init.js';
                _natid = '63efc5b8d97cddbc3d965e3a';
                _seedtag = '1853-0252-01';
                _vdp = false;
            }

            break;

        case 'www.solofinanza.it':
            _adsense = true;
            _mgid_flag = true;
            _viralize = false;
            _vidoomy = true;
            _vidoomy_link = 'https://ads.vidoomy.com/solofinanzait_21169.js';
            _teads = '155076';
            _mgid_url = 'https://jsc.mgid.com/s/o/solofinanza.it.1351424.js';
            _adkaora = true;
            _adkaora_link = 'https://cdn.adkaora.space/magellano/solofinanza/prod/adk-init.js';
            _natid = '63efbeefd97cddbc3d965884';
            _seedtag = '1818-3948-01';
            break;

        case 'www.newscinema.it':
            _adsense = true;
            _viralize = false;
            _teads = '161717';
            _vidoomy = true;
            _vidoomy_link = 'https://ads.vidoomy.com/newscinema_21625.js';
            _mgid_flag = true;
            _mgid_url = 'https://jsc.mgid.com/n/e/newscinema.it.1405593.js';
            _adkaora = true;
            _adkaora_link = 'https://cdn.adkaora.space/magellano/newscinema/prod/adk-init.js';
            _natid = '63f327ccc2711a37861f2aee';
            _seedtag = '9223-4462-01';
            break;

        case 'www.irenemilito.it':
            _adsense = true;
            _viralize = true;
            _teads = '161720';
            _mgid_flag = true;
            _mgid_url = 'https://jsc.mgid.com/i/r/irenemilito.it.1405591.js';
            _adkaora = false;
            _adkaora_link = 'https://cdn.adkaora.space/magellano/fortementein/prod/adk-init.js';
            break;

        case 'www.ilromanista.it':

            //No consent / consent dell'utente sui cookie
            if (nocmp) {
                _adsense = false;
                var random_video = Math.random();
                if (random_video < 0.5) {
                    console.log('Video: _vidoomy');
                    _vidoomy = false;
                    _vidoomy_link = 'https://ads.vidoomy.com/ilromanista_21576.js';
                }
                else {
                    console.log('Video: _viralize');
                    _viralize = false;
                }
                _teads = '160819';
                _mgid_flag = true;
                _mgid_url = 'https://jsc.mgid.com/i/l/ilromanista.it.1407805.js';
                _adkaora = true;
                _adkaora_link = 'https://cdn.adkaora.space/magellano/ilromanista/prod/adk-init.js';
                _natid = '63efbea6d97cddbc3d965873';
                _seedtag = '1057-5085-01';

            }
            else {
                _adsense = true;
                var random_video = Math.random();
                if (random_video < 0.5) {
                    console.log('Video: _vidoomy');
                    _vidoomy = true;
                    _vidoomy_link = 'https://ads.vidoomy.com/ilromanista_21576.js';
                }
                else {
                    console.log('Video: _viralize');
                    _viralize = true;
                }
                _teads = '160819';
                _mgid_flag = true;
                _mgid_url = 'https://jsc.mgid.com/i/l/ilromanista.it.1407805.js';
                _adkaora = true;
                _adkaora_link = 'https://cdn.adkaora.space/magellano/ilromanista/prod/adk-init.js';
                _natid = '63efbea6d97cddbc3d965873';
                _seedtag = '9787-4987-01';
            }



            break;

        case 'www.solospettacolo.it':
            _mgid_flag = true;
            _adsense = true;
            _viralize = true;
            _teads = '155223';
            _adkaora = true;
            _adkaora_link = 'https://cdn.adkaora.space/magellano/solospettacolo/prod/adk-init.js';
            _mgid_url = 'https://jsc.mgid.com/s/o/solospettacolo.it.1351426.js';
            _natid = '63efbe42d97cddbc3d96584d';
            _seedtag = '6043-0651-01';
            break;

        default:

    }

    if (_fluid) {
        (function () {
            var nat = document.createElement('script');
            nat.type = 'text/javascript';
            nat.async = true;
            nat.src = '//fluid.4strokemedia.com/www/fluid/player.php';
            var nats = document.getElementsByTagName('script')[0];
            nats.parentNode.insertBefore(nat, nats);
        })();
    }

    if (_sky_display) {
        (function () {
            var nat = document.createElement('script');
            nat.type = 'text/javascript';
            nat.async = true;
            nat.src = '//adx.4strokemedia.com/www/delivery/asyncjs.php';
            var nats = document.getElementsByTagName('script')[0];
            nats.parentNode.insertBefore(nat, nats);
        })();
    }


    if (_adsense) {
        (function () {
            var nat = document.createElement('script');
            nat.type = 'text/javascript';
            nat.async = true;
            nat.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2121737085751619';
            var nats = document.getElementsByTagName('script')[0];
            nats.parentNode.insertBefore(nat, nats);
        })();
    }

    if (_mgid_flag) {
        (function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = _mgid_url;
            var sc = document.getElementsByTagName('script')[0];
            sc.parentNode.insertBefore(s, sc);
        })();
    }

    if (_adkaora) {
        (function () {
            var s = document.createElement('script');
            s.type = 'module';
            s.async = true;
            s.setAttribute("defer", "");
            s.src = _adkaora_link;
            var sc = document.getElementsByTagName('script')[0];
            sc.parentNode.insertBefore(s, sc);
        })();
        (function () {
            var s = document.createElement('link');
            s.setAttribute("rel", "modulepreload");
            s.setAttribute("href", _adkaora_link);
            var sc = document.getElementsByTagName('script')[0];
            sc.parentNode.insertBefore(s, sc);
        })();
    }

    if (_vidoomy) {
        (function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = _vidoomy_link;
            var sc = document.getElementsByTagName('script')[0];
            sc.parentNode.insertBefore(s, sc);
        })();
    }

    if (_viralize) {
        (function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.setAttribute("data-wid", "auto");
            s.src = 'https://ads.viralize.tv/display/?zid=AAEjfYgEwKpGwrFh';
            var sc = document.getElementsByTagName('script')[0];
            sc.parentNode.insertBefore(s, sc);
        })();
    }

    if (_teads != '') {
        (function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = '//a.teads.tv/page/' + _teads + '/tag';
            var sc = document.getElementsByTagName('script')[0];
            sc.parentNode.insertBefore(s, sc);
        })();
    }

    if (_seedtag != '') {
        (function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = '//t.seedtag.com/t/' + _seedtag + '.js';
            var sc = document.getElementsByTagName('script')[0];
            sc.parentNode.insertBefore(s, sc);
        })();
    }



    if (_vdp) {
        (function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://unifiedads.magellanotech.it/scripts/loader_video_local_lineadiretta24.js';
            var sc = document.getElementsByTagName('script')[0];
            sc.parentNode.insertBefore(s, sc);
        })();
    }

    if (_natid != '') {
        //var _nat = window._nat || [];
        window._nat = window._nat || [];
        window._nat.push(['id', _natid]);
        (function () {
            var nat = document.createElement('script');
            nat.type = 'text/javascript';
            nat.async = true;
            nat.src = '//cdn.nativery.com/widget/js/nat.js';
            var nats = document.getElementsByTagName('script')[0];
            nats.parentNode.insertBefore(nat, nats);
        })();
    }

    var FAILSAFE_TIMEOUT = 2000;
    var requestManager = {
        adserverRequestSent: false,
        aps: false,
        prebid: false
    };

    //quando vengono restituiti sia APS che Prebid, avvia la richiesta di annuncio    
    function biddersBack() {
        if (requestManager.aps && requestManager.prebid) {
            sendAdserverRequest();
        }
        return;
    }

    // sends adserver request
    function sendAdserverRequest() {
        
        if (requestManager.adserverRequestSent === true) {
            console.log("========>", requestManager);
            return;
        }
        requestManager.adserverRequestSent = true;
        googletag.cmd.push(function () {
            googletag.pubads().refresh();
        });
        console.log("=========>", googletag);
    }

    // sends bid request to APS and Prebid
    function requestHeaderBids() {

        // APS request
        apstag.fetchBids({
            timeout: 2000
        },
            function (bids) {
                googletag.cmd.push(function () {
                    apstag.setDisplayBids();
                    requestManager.aps = true; // segnala che la richiesta APS è stata completata
                    biddersBack(); //controlla se sono stati restituiti sia APS che Prebid
                });
            }
        );

        const customConfigObject = {
            "buckets": [{
                "precision": 2,
                "max": 3,
                "increment": 0.01
            },
            {
                "max": 8,
                "increment": 0.05
            },
            {
                "max": 20,
                "increment": 0.5
            },
            {
                "max": 30,
                "increment": 1.0
            }
            ]
        };

        pbjs.setConfig({
            priceGranularity: customConfigObject,
            consentManagement: {
                gdpr: {
                    cmpApi: 'iab',
                    timeout: 8000,
                    defaultGdprScope: true
                }
            }
        });

        //TODO questo cosa fa?
        pbjs.que.push(function () {
            pbjs.requestBids({
                bidsBackHandler: function () {
                    googletag.cmd.push(function () {
                        pbjs.setTargetingForGPTAsync();
                        requestManager.prebid = true; // signals that Prebid request has completed
                        biddersBack(); // checks whether both APS and Prebid have returned
                    })
                }
            });
        });
    }

    // initiate bid request

    requestHeaderBids();

    // set failsafe timeout

    window.setTimeout(function () {
        sendAdserverRequest();
    }, FAILSAFE_TIMEOUT);





};



(function () {
    var host = window.location.hostname;
    var element = document.createElement('script');
    var firstScript = document.getElementsByTagName('script')[0];
    var url = 'https://cmp.quantcast.com'
        .concat('/choice/', '5uBzFnJdUcdpe', '/', host, '/choice.js?tag_version=V2');
    var uspTries = 0;
    var uspTriesLimit = 3;
    element.async = true;
    element.type = 'text/javascript';
    element.src = url;

    firstScript.parentNode.insertBefore(element, firstScript);

    function makeStub() {
        var TCF_LOCATOR_NAME = '__tcfapiLocator';
        var queue = [];
        var win = window;
        var cmpFrame;

        function addFrame() {
            var doc = win.document;
            var otherCMP = !!(win.frames[TCF_LOCATOR_NAME]);

            if (!otherCMP) {
                if (doc.body) {
                    var iframe = doc.createElement('iframe');

                    iframe.style.cssText = 'display:none';
                    iframe.name = TCF_LOCATOR_NAME;
                    doc.body.appendChild(iframe);
                } else {
                    setTimeout(addFrame, 5);
                }
            }
            return !otherCMP;
        }

        //TODO ????
        function tcfAPIHandler() {
            var gdprApplies;
            var args = arguments;

            if (!args.length) {
                return queue;
            } else if (args[0] === 'setGdprApplies') {
                if (
                    args.length > 3 &&
                    args[2] === 2 &&
                    typeof args[3] === 'boolean'
                ) {
                    gdprApplies = args[3];
                    if (typeof args[2] === 'function') {
                        args[2]('set', true);
                    }
                }
            } else if (args[0] === 'ping') {
                var retr = {
                    gdprApplies: gdprApplies,
                    cmpLoaded: false,
                    cmpStatus: 'stub'
                };

                if (typeof args[2] === 'function') {
                    args[2](retr);
                }
            } else {
                if (args[0] === 'init' && typeof args[3] === 'object') {
                    args[3] = Object.assign(args[3], { tag_version: 'V2' });
                }
                queue.push(args);
            }
        }

        function postMessageEventHandler(event) {
            var msgIsString = typeof event.data === 'string';
            var json = {};

            try {
                if (msgIsString) {
                    json = JSON.parse(event.data);
                } else {
                    json = event.data;
                }
            } catch (ignore) { }

            var payload = json.__tcfapiCall;

            if (payload) {
                window.__tcfapi(
                    payload.command,
                    payload.version,
                    function (retValue, success) {
                        var returnMsg = {
                            __tcfapiReturn: {
                                returnValue: retValue,
                                success: success,
                                callId: payload.callId
                            }
                        };
                        if (msgIsString) {
                            returnMsg = JSON.stringify(returnMsg);
                        }
                        if (event && event.source && event.source.postMessage) {
                            event.source.postMessage(returnMsg, '*');
                        }
                    },
                    payload.parameter
                );
            }
        }

        while (win) {
            try {
                if (win.frames[TCF_LOCATOR_NAME]) {
                    cmpFrame = win;
                    break;
                }
            } catch (ignore) { }

            if (win === window.top) {
                break;
            }
            win = win.parent;
        }
        if (!cmpFrame) {
            addFrame();
            win.__tcfapi = tcfAPIHandler;
            win.addEventListener('message', postMessageEventHandler, false);
        }
    };

    makeStub();

    var uspStubFunction = function () {
        var arg = arguments;
        if (typeof window.__uspapi !== uspStubFunction) {
            setTimeout(function () {
                if (typeof window.__uspapi !== 'undefined') {
                    window.__uspapi.apply(window.__uspapi, arg);
                }
            }, 500);
        }
    };

    var checkIfUspIsReady = function () {
        uspTries++;
        if (window.__uspapi === uspStubFunction && uspTries < uspTriesLimit) {
            console.warn('USP is not accessible');
        } else {
            clearInterval(uspInterval);
        }
    };

    if (typeof window.__uspapi === 'undefined') {
        window.__uspapi = uspStubFunction;
        var uspInterval = setInterval(checkIfUspIsReady, 6000);
    }

    window.__tcfapi('ping', 2, function (pingData) {
        //console.log('cmp responded:', pingData);
    });

    window.__tcfapi('addEventListener', 2, function (tcData, listenerSuccess) {
        /*
        if (listenerSuccess) {
            // check the eventstatus
            if ((tcData.eventStatus === 'useractioncomplete' ||
                    tcData.eventStatus === 'tcloaded') && tcData.gdprApplies) {
  
                setTimeout(parallelExecution, 150);
  
                // Block of code for parsing tcData for IAB Vendor consents
                if ((tcData.vendor.consents[99] || tcData.vendor.legitimateInterests[99]) &&
                    (tcData.purpose.consent[2] && tcData.purpose.legitimateInterests[3] &&
                        (tcData.purpose.consent[4] || tcData.purpose.legitimateInterests[4]))) {
                    // perform the function for vendor #99, i.e. insert the vendor tag or make the vendor SDK call
                }
  
            }
        }
        */


        if (listenerSuccess && (tcData.eventStatus === "tcloaded" || tcData.eventStatus === "useractioncomplete")) {
            if (tcData.vendor.consents && Object.keys(tcData.vendor.consents).length === 0 && Object.getPrototypeOf(tcData.vendor.consents) === Object.prototype) {
                console.log("MAGELLANO QNTC: NO consent");
                nocmp = true;
                setTimeout(executeParallelAuctionAlongsidePrebid, 150);
            }
            if (!tcData.gdprApplies) {
                googletag.pubads().setRequestNonPersonalizedAds(1);
                setTimeout(executeParallelAuctionAlongsidePrebid, 150);
            } else {
                if (tcData.purpose.consents[1] || false) {
                    if (tcData.vendor.consents[755] || false) {
                        if (!(tcData.purpose.consents[3] || false) || !(tcData.purpose.consents[4] || false)) {
                            googletag.pubads().setRequestNonPersonalizedAds(1);
                        }
                        setTimeout(executeParallelAuctionAlongsidePrebid, 150);
                    }
                }
            }
        }

    });



})();