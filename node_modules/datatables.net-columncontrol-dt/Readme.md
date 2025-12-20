# ColumnControl for DataTables with styling for [DataTables](https://datatables.net/)

This is the distribution package for the [ColumnControl extension](https://datatables.net/extensions/columncontrol) for [DataTables](https://datatables.net/) with styling for [DataTables](https://datatables.net/).

ColumnControl lets you add column specific control content to the header and footer of a DataTable. Built-in content types include ordering buttons, search inputs and search lists. The content shown is fully configurable to suit your use cases.


## Installation

### Browser

To use DataTables with a simple `<script>` tag, rather than using this package, it is recommended that you use the [DataTables download builder](//datatables.net/download) which can create CDN or locally hosted packages for you, will all dependencies satisfied.

### npm

For installation via npm, yarn and other similar package managers, install this package with your package manager - e.g.:

```
npm install datatables.net-dt
npm install datatables.net-columncontrol-dt
```

Then, to load and initialise the software in your code use:

```
import DataTable from 'datatables.net-dt';
import 'datatables.net-columncontrol-dt'

new DataTable('#myTable', {
    // initialisation options
});
```


## Documentation

Full documentation and examples for ColumnControl can be found [on the DataTables website](https://datatables.net/extensions/columncontrol).


## Bug / Support

Support for DataTables is available through the [DataTables forums](//datatables.net/forums) and [commercial support options](//datatables.net/support) are available.

### Contributing

If you are thinking of contributing code to DataTables, first of all, thank you! All fixes, patches and enhancements to DataTables are very warmly welcomed. This repository is a distribution repo, so patches and issues sent to this repo will not be accepted. Instead, please direct pull requests to the [DataTables/ColumnControl](http://github.com/DataTables/ColumnControl). For issues / bugs, please direct your questions to the [DataTables forums](//datatables.net/forums).


## License

This software is released under the [MIT license](//datatables.net/license). You are free to use, modify and distribute this software, but all copyright information must remain.

