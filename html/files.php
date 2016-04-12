<div id="filesCUF" ng-controller="FilesCtrl">

    <select ng-change="scanPathDir()"  ng-options="dir for dir in dirs" ng-model="pathDir" >

    </select>

    <span ng-if="!_.isUndefined(pathDir)&&files.length==0"><?php _e("Any file was found in this path",'cuf') ?></span>

    <table ng-if="files.length>0"  class="wp-list-table widefat fixed">
        <thead>
        <tr>
            <th class="manage-column column-title">Name</th>
            <th class="manage-column column-title">Size</th>
            <th class="manage-column column-title">Type</th>
            <th class="manage-column column-title">Path</th>
            <th class="manage-column column-title">Attached</th>
            <th class="manage-column column-title">Used</th>
            <th class="manage-column column-title">InServer</th>
            <th class="manage-column column-title">Action</th>
        </tr>
        </thead>
        <tbody>
            <tr ng-repeat="file in files">
                <td>{{file.name}}</td>
                <td>{{file.size}}</td>
                <td>{{file.type}}</td>
                <td>{{file.path}}</td>
                <td>
                    <span ng-if="file.status.attach==status.ATTACH.UNKNOWN">UNKNOWN</span>
                    <!-- <span ng-if="file.status.attach=="></span> -->
                </td>
                <td>
                    <span ng-if="file.status.used==status.USED.UNKNOWN">UNKNOWN</span>
                   <!-- <span ng-if="file.status.used=="></span>-->
                </td>
                <td>
                       <span ng-if="file.status.inServer==status.IN_SERVER.UNKNOWN">UNKNOWN</span>
                   <!-- <span ng-if="file.status.inServer=="></span>-->
                </td>
                <td>

                </td>
            </tr>
        </tbody>


    </table>
</div>