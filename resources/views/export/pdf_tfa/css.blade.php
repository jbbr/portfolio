<style>

    @if( $type == "individual")
        @page {
            margin-top: 100px;
        }
    @endif

    body {
        font-family: 'Lato', 'Open Sans', sans-serif;
        line-height: 1.4;
        font-size: 10pt;
        font-weight: 300;

        @if( $type == "individual")
             color: #57585A;
        @else
             color: #000000;
        @endif

    }

    .header,
    .footer,
    .entry-footer {
        width: 100%;
        text-align: right;
        position: fixed;
        font-size: 16px;
    }

    @if( $type == "individual")
        .header {
            top: -30px;
        }
    @else
        .header {
            top: 20px;
        }
    @endif



    .puncher-hole {
        background-color: #bcbdc0;
        width: 20px;
        height: 20px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        position: fixed;
        left: -12px;
    }

    .puncher-hole.top {
        top: 301px;
    }

    .puncher-hole.bottom {
        top: 603px;
    }

    .footer {
        bottom: 0;
    }

    .entry-footer {
        margin-left: 80px;
        bottom: 55px;
    }

    .entry-footer table {
        border: 1px solid black;
        border-collapse: collapse;
        width: 583px;
        line-height: 0.9;
        font-size: 15px;
    }

    .entry-footer table td {
        border: 1px solid black;
        border-collapse: collapse;
        vertical-align: top;
        padding-left: 2px;
    }

    .pagenum:before {
        content: counter(page);
    }

    .content {
        margin-left: 80px;
    }

    /** Ausbildungsnachweis */
    .entry > .entry_head {
        font-size: 16px;
        font-weight: bold;
    }

    .entry > .entry_head > .title {
        font-weight: bold;
        font-size: 20px;
    }

    .entry > .entry_head > .sub_title {
        font-weight: normal;
        font-size: 20px;
    }

    .entry .extra .title {

    }

    .entry .extra .value {
        font-weight: normal;
    }

    /** Media */
    .media .integrate .title {
        font-size: 12pt;
        margin: 10px 0;
        font-weight: bold;
    }

    .media .integrate .container {
        margin-right: 11px;
        float: left;
        width: 285px;
        height: auto;
    }

    .media .integrate .container .image {
        border: 1pt solid #000000;
        max-width: 285px;
        max-height: 180px;
    }

    .media .integrate .container .desc {
        border: none;
    }

    .media .attachment .title {
        font-size: 12pt;
        margin-top: 10px;
        font-weight: bold;
    }

    /** Anhänge */
    .attachment-overview {
        margin-top: 60px;
        margin-left: 80px;
    }

    .attachment-overview .title {
        font-weight: bold;
        font-size: 20px;
    }

    .attachment-img {
        margin-top: 70px;
        margin-left: 20px;
        width: 680px;
        height: auto;
    }

    /** Individueller Bericht */
    .entry-indiv {
        margin-top: 0px;
    }

    .entry-indiv .entry-head .title {
        font-size: 32px;
    }

    .entry-indiv .entry-head .sub_title {
        color: #0EA3B1;
        font-weight: bold;
        font-size: 16px;
    }

    .entry-indiv .entry-head .tags-list {
        font-size: 16px;
        font-weight: bold;
    }

    .entry-indiv .entry-head .tags-list .title {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .entry-indiv .entry-head .tags-list .tag {
        font-size: 12px;
        font-weight: bold;
        background-color: #0EA3B1;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        color: #FFFFFF;
        float: left;
        padding: 1px 5px 4px 5px;
        margin-right: 5px;
    }

    /** Cover */
    .cover {
        position: absolute;
        top: 276px;
        right: 0;
        width: 90%;
    }

    .cover .title {
        font-size: 32px;
        text-transform: uppercase;
    }

    .cover .description {
        font-size: 16px;
    }

    .cover .user {
        text-transform: uppercase;
        font-size: 18px;
    }

    .cover .date_of_creation {
        font-size: 16px;
    }

    /** Zwischenseite */
    .intermediate-page {
        position: absolute;
        top: 22%;
        right: 0;
        left: 110px;
    }

    .intermediate-page .head {
        font-size: 20px;
        text-align: center;
        font-weight: bold;
    }

    /** Profil */
    .profile .title {
        text-align: center;
        font-weight: bold;
        font-size: 32px;
        padding-bottom: 16px;
    }

    .profile .sub_title {
        text-align: center;
        font-weight: bold;
        font-size: 20px;
        width: 80%;
        padding-left: 10%;
    }

    .profile.second .logo {
        padding-left: 50px;
    }

    .profile.second .sub_title {
        text-align: left;
        padding-top: 30px;
        padding-bottom: 30px;
    }

    .profile .description {
        padding-bottom: 40px;
        text-align: center;
        font-size: 18px;
    }
    .profile .informations {
        margin-left: 45px;
    }
    .profile .informations .block {
        background-color: #E6E7E9;
        font-size: 16px;
        padding: 0 0 8px 14px;
        margin-bottom: 20px;
    }

    .profile .informations .block input[type='checkbox'] {
        position: absolute;
        top: 6px;
    }

    .profile .informations .date {
        font-size: 16px;
        padding-top: 20px;
        float: left;
    }

    .profile .informations .sign {
        font-size: 16px;
        padding-top: 20px;
        float: right;
    }
    .profile .informations .sign .sub {
        font-size: 12px;
    }
    .profile .informations .attention {
        padding-top: 34px;
        font-size: 14px;
        font-weight: bold;
        font-style: italic;
    }

        /** Helper */
    .page-break,
    .pagebreak {
        page-break-after: always;
    }

    .clear {
        clear: both;
    }

    .hr {
        width: 100%;
        border-top: 2px solid #000000;
        margin-top: 10px;
        height: 6px;
    }

    .hr.green {
        border-top: 2px solid #B1E0E5;
    }

    .green {
        color: #0ea3d9;
    }

    .left.floated {
        float: left;
    }

    .clearer {
        clear: both;
    }

    .width-50 {
        width: 50%;
    }

    .padding-l-25 {
        padding-left: 25px;
    }
    .padding-b-25 {
        padding-bottom: 25px;
    }

</style>
