import './bootstrap';
import './libs';

import $ from 'jquery';
window.$ = window.jQuery = $;

// DataTables Core + Bootstrap 5
import dt from 'datatables.net-bs5';
dt(window, $);

// DataTables Buttons + Bootstrap 5
import buttons from 'datatables.net-buttons-bs5';
buttons(window, $);

// Extra Button Types
import 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';

// Styles
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
