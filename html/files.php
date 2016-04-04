<div id="filesCUF" ng-controller="FilesCtrl">

    <select ng-change="scanPathDir()" ng-model="pathDir" ng-options="dir for dir in directories.data"></select>

    <span ng-if="_.isUndefined(pathDir)&&files.length==0"><?php _e("Any file was found in this folder",'cuf') ?></span>

    <table ng-if="files.length>0">
        <thead>
        <tr>
            <th>Name</th>
            <th>Size</th>
            <th>Type</th>
            <th>Attached</th>
            <th>Used</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <tr ng-repeat="file in files.data">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>


    </table>
</div>