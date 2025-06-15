@push('header')
    <script src="{{ asset('vendor/vue/2.7/vue.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('vendor/element-ui/element-ui.css') }}">
    <script src="{{ asset('vendor/element-ui/element-ui.js') }}"></script>
    <link rel="stylesheet" href="{{  asset('vendor/cropper/cropper.min.css') }}">
    <script src="{{ asset('vendor/cropper/cropper.min.js') }}"></script>
    <script src="{{ asset('vendor/vuedraggable/vuedraggable.umd.min.js') }}"></script>

  <script>
    // Get configuration from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    window.fileManagerConfig = {
      multiple: urlParams.get('multiple') === '1',
      type: urlParams.get('type') || 'all',
      callback: window.parent.fileManagerCallback,
      driver: '{{ $config['driver'] }}',
      endpoint: '{{ $config['endpoint'] }}',
      bucket: '{{ $config['bucket'] }}',
      baseUrl: '{{ $config['baseUrl'] }}'
    };
  </script>

  <script>
    // HTTP request wrapper
    (function(window) {
      'use strict';

      window.getApiToken = () => {
        const currentToken = document.querySelector('meta[name="api-token"]')?.getAttribute('content');
        const parentToken = window.parent?.document.querySelector('meta[name="api-token"]')?.getAttribute('content');
        return currentToken || parentToken;
      };

      // Create axios instance
      const http = axios.create({
        baseURL: '/api/panel/',
        timeout: 30000,
        headers: {
          'Authorization': 'Bearer ' + window.getApiToken()
        }
      });

      // Add request interceptor to ensure each request uses the latest token
      http.interceptors.request.use(config => {
        // Get fresh token before each request
        config.headers.Authorization = 'Bearer ' + window.getApiToken();

        // Add loading indicator
        if (window.layer) {
          layer.load(2, {
            shade: [0.3, '#fff']
          });
        }
        return config;
      });

      // Response interceptor
      http.interceptors.response.use(
        response => {
          if (window.layer) {
            layer.closeAll('loading');
          }
          return response.data;
        },
        error => {
          if (window.layer) {
            layer.closeAll('loading');
          }

          // Error handling
          if (error.response) {
            const message = error.response.data.message || 'Request failed';
            // Use Element UI message notification
            if (window.Vue && window.ELEMENT) {
              ELEMENT.Message.error(message);
            }

            switch (error.response.status) {
              case 401:
                // Unauthorized handling
                break;
              case 403:
                // Forbidden access handling
                break;
              case 404:
                // Not found handling
                break;
              default:
                // Other errors
                break;
            }
          }
          return Promise.reject(error);
        }
      );
      window.http = http; // Ensure http is also added to window object
    })(window);
  </script>

  <style>
    .container-fluid {
      padding-right: 0;
      padding-left: 0;
    }

    .file-manager {
      background: #fff;
      border-radius: 4px;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    /* Left sidebar folder tree styles */
    .folder-tree {
      border-right: 1px solid #EBEEF5;
      overflow-y: auto;
      background: #fff;
      height: 100%;
    }

    /* Right side file list styles */
    .file-list {
      padding: 20px;
      overflow-y: auto;
      height: calc(100vh - 100px);
      /* Set a fixed height, minus the height of header toolbar and other areas */
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    /* File list content container */
    .file-list-content {

      /* Ensure content can scroll properly */
    }

    /* Top toolbar */
    .file-toolbar {
      padding: 15px 20px;
      border-bottom: 1px solid #EBEEF5;
      background: #fff;
      border-radius: 4px 4px 0 0;
      flex-shrink: 0;
    }

    /* File card styles */
    .file-card {
      border: 1px solid #EBEEF5;
      border-radius: 4px;
      transition: all 0.3s;
      cursor: pointer;
      position: relative;
      margin-bottom: 15px;
      background: #fff;
      overflow: hidden;
    }

    /* File thumbnail container */
    .file-thumb {
      position: relative;
      padding: 6px;
      height: 140px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #fafafa;
      border-bottom: 1px solid #EBEEF5;
      user-select: none;
    }

    .preview-button {
      position: absolute;
      top: 8px;
      right: 8px;
      padding: 1px;
      background-color: rgb(152, 34, 255);
      border-radius: 4px;
      font-size: 12px;
      opacity: 0;
      cursor: pointer;
      z-index: 2;
      display: flex;
      align-items: center;
    }

    /* Show preview button on hover */
    .file-thumb:hover .preview-button {
      opacity: 1;
      color: rgba(255, 255, 255, 0.8);
    }

    .el-image:hover {
      transform: scale(1.05);
    }

    /* Preview button hover effect */
    .preview-button:hover {
      transform: scale(1.05);
    }

    /* Disable image dragging */
    .file-thumb img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      pointer-events: none;
      user-select: none;
      -webkit-user-drag: none;
    }

    /* File info area */
    .file-info {
      padding: 12px 16px;
    }

    /* File name styles */
    .file-name {
      font-weight: 500;
      color: #303133;
      margin-bottom: 6px;
      font-size: 14px;
      line-height: 1.4;
      word-break: break-all;
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    /* File type styles */
    .file-type {
      font-size: 12px;
      color: #909399;
      line-height: 1.4;
    }

    /* Custom Element UI theme colors */
    .el-button--primary {
      background-color: #8446df;
      border-color: #8446df;
    }

    .el-button--primary:hover,
    .el-button--primary:focus {
      background: #9969e5;
      border-color: #9969e5;
    }

    .el-tree-node.is-current>.el-tree-node__content {
      background-color: #f0e6fc !important;
      color: #8446df;
    }

    .el-tree-node__content:hover {
      background-color: #f5f7fa;
    }

    /* Pagination container styles */
    .pagination-container {
      padding: 20px;
      text-align: right;
      background: #fff;
      border-top: 1px solid #EBEEF5;
      flex-shrink: 0;
    }

    /* Loading state styles */
    .el-loading-spinner .el-loading-text {
      color: #8446df;
    }

    .el-loading-spinner .path {
      stroke: #8446df;
    }

    /* Pagination component theme color customization */
    .el-pagination.is-background .el-pager li:not(.disabled).active {
      background-color: #8446df;
    }

    .el-pagination.is-background .el-pager li:not(.disabled):hover {
      color: #8446df;
    }

    .el-pagination .el-select .el-input .el-input__inner:hover {
      border-color: #8446df;
    }

    /* Empty state styles */
    .el-empty {
      padding: 40px 0;
    }

    /* File list loading state container */
    .file-list .el-loading-mask {
      border-radius: 4px;
    }

    /* Adjust file list height to make room for pagination */
    .file-list {}

    /* Adjust file grid layout */
    .el-row {
      margin-right: -7.5px !important;
      margin-left: -7.5px !important;
    }

    .el-col {
      padding-right: 7.5px !important;
      padding-left: 7.5px !important;
    }

    /* Button styles modification section */
    /* Element UI button style reset */
    .el-button {
      font-weight: normal;
      border-radius: 4px;
      padding: 8px 15px;
      line-height: 1;
      height: auto;
    }

    .el-button--small {
      padding: 7px 12px;
      font-size: 12px;
    }

    .el-button--mini {
      padding: 5px 10px;
      font-size: 12px;
    }

    /* Primary button styles */
    .el-button--primary {
      background-color: #8446df;
      border-color: #8446df;
      color: #fff;
    }

    .el-button--primary:hover,
    .el-button--primary:focus {
      background: #9969e5;
      border-color: #9969e5;
      color: #fff;
    }

    .el-button--primary:active {
      background: #7339c7;
      border-color: #7339c7;
      color: #fff;
    }

    /* Default button styles */
    .el-button--default {
      background: #fff;
      border-color: #dcdfe6;
      color: #606266;
    }

    .el-button--default:hover,
    .el-button--default:focus {
      background: #f4f4f5;
      border-color: #8446df;
      color: #8446df;
    }

    /* Button group styles */
    .el-button-group {
      display: inline-flex;
      vertical-align: middle;
    }

    .el-button-group .el-button {
      border-radius: 0;
    }

    .el-button-group .el-button:first-child {
      border-top-left-radius: 4px;
      border-bottom-left-radius: 4px;
    }

    .el-button-group .el-button:last-child {
      border-top-right-radius: 4px;
      border-bottom-right-radius: 4px;
    }

    .el-button-group .el-button:not(:first-child):not(:last-child) {
      margin: 0 -1px;
    }

    .el-button.is-disabled,
    .el-button.is-disabled:hover,
    .el-button.is-disabled:focus {
      color: #c0c4cc;
      cursor: not-allowed;
      background-image: none;
      background-color: #fff;
      border-color: #ebeef5;
    }

    /* Icon button */
    .el-button [class*="el-icon-"]+span {
      margin-left: 5px;
    }

    /* Toolbar button spacing */
    .file-toolbar .el-button-group+.el-button-group {
      margin-left: 10px;
    }

    /* Text button */
    .el-button--text {
      border: 0;
      padding: 0;
      background: transparent;
      color: #8446df;
    }

    .el-button--text:hover,
    .el-button--text:focus {
      color: #9969e5;
      background: transparent;
    }

    .el-image {
      width: 100%;
      height: 100%;
    }

    .el-image-viewer__img {}

    .file-uploader {
      text-align: center;
    }

    .file-uploader .el-upload {
      width: 100%;
    }

    .file-uploader .el-upload-dragger {
      width: 100%;
      height: 200px;
    }

    .file-uploader .el-icon-upload {
      margin: 40px 0 16px;
      font-size: 48px;
      color: #8446df;
    }

    .file-uploader .el-upload__text {
      color: #606266;
      font-size: 14px;
      margin: 0 0 16px;
    }

    .file-uploader .el-upload__text em {
      color: #8446df;
      font-style: normal;
    }

    .file-uploader .el-upload__tip {
      color: #909399;
    }

    .cropper-dialog {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      z-index: 2001;
      width: 900px;
    }

    .cropper-container {
      width: 100%;
      height: 500px;
      margin-bottom: 20px;
      overflow: hidden;
    }

    .cropper-container img {
      max-width: 100%;
      display: block;
    }

    .cropper-controls {
      text-align: right;
      padding-top: 15px;
      border-top: 1px solid #eee;
    }

    .cropper-controls button {
      margin-left: 10px;
      padding: 6px 20px;
    }

    .cropper-mask {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 2000;
    }

    /* Element UI dialog layer reference */
    .el-dialog__wrapper {
      z-index: 1000;
    }

    .v-modal {
      z-index: 999;
    }

    /* Folder tree icon styles */
    .el-tree-node__content .el-icon-folder,
    .el-tree-node__content .el-icon-folder-opened {
      font-size: 16px;
    }

    /* Selected folder styles */
    .el-tree-node.is-current>.el-tree-node__content {
      background-color: #f0e6fc !important;
      color: #8446df;
    }

    /* Mouse hover styles */
    .el-tree-node__content:hover {
      background-color: #f5f7fa;
    }

    /* Expanded folder icon color */
    .el-tree-node.is-expanded>.el-tree-node__content .el-icon-folder {
      color: #8446df;
    }

    /* Tree node content spacing */
    .custom-tree-node {
      display: flex;
      align-items: center;
      font-size: 14px;
    }

    /* Add right-click context menu styles */
    .file-card-context-menu {
      position: fixed;
      background: white;
      border: 1px solid #EBEEF5;
      border-radius: 4px;
      box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
      z-index: 3000;
    }

    .file-card-context-menu ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .file-card-context-menu li {
      padding: 8px 16px;
      cursor: pointer;
      font-size: 14px;
      display: flex;
      align-items: center;
    }

    .file-card-context-menu li:hover {
      background-color: #f5f7fa;
      color: #8446df;
    }

    .file-card-context-menu li i {
      margin-right: 8px;
    }

    .file-card {
      position: relative;
    }

    .file-checkbox {
      position: absolute;
      top: 10px;
      left: 10px;
      z-index: 1;
    }

    .file-checkbox .el-checkbox {
      margin-right: 0;
    }

    /* Selected state styles */
    .file-card.selected {
      border-color: #8446df;
      background: rgba(132, 70, 223, 0.05);
    }

    /* Hover effect in multi-select mode */
    .file-card:hover .file-checkbox {
      opacity: 1;
    }

    .file-checkbox {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 1;
      background: rgba(255, 255, 255, 0.8);
      border-radius: 3px;
      padding: 2px;
    }
    .file-checkbox .el-checkbox {
      margin-right: 0;
    }

    .file-card.selected .file-checkbox {
      opacity: 1;
    }

    
  /* Drag prompt */
    .el-tree-node.drag-over>.el-tree-node__content::after {
      content: "Drop here";
      position: absolute;
      right: 10px;
      color: #8446df;
      font-size: 12px;
      background: rgba(255, 255, 255, 0.9);
      padding: 2px 6px;
      border-radius: 3px;
    }

    /* Drag related styles */
    .file-card.dragging {
      opacity: 0.6;
      transform: scale(1.05);
      cursor: move;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Folder tree drag target styles */
    .el-tree-node.drag-over>.el-tree-node__content {
      background-color: #f0e6fc !important;
      border: 2px dashed #8446df;
      animation: dropTarget 1s ease infinite;
    }

    @keyframes dropTarget {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.02);
      }

      100% {
        transform: scale(1);
      }
    }

    /* Drag related styles */
    .file-card.dragging {
      opacity: 0.6;
      transform: scale(0.95);
      cursor: move;
    }

    .file-card[data-is-dir="true"].drag-over {
      background-color: #f0e6fc;
      border: 2px dashed #8446df;
      animation: dropTarget 1s ease infinite;
    }

    @keyframes dropTarget {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.02);
      }

      100% {
        transform: scale(1);
      }
    }

    /* Folder receiving drag prompt */
    .file-card[data-is-dir="true"].drag-over::after {
      content: "Drop here";
      position: absolute;
      bottom: 5px;
      right: 5px;
      font-size: 12px;
      color: #8446df;
      background: rgba(255, 255, 255, 0.9);
      padding: 2px 6px;
      border-radius: 3px;
    }

    /* Folder tree node styles */
    .el-tree-node__wrapper {
      width: 100%;
      padding: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
    }

    @media screen and (max-width: 768px) {
      .el-tree-node__wrapper {
        padding: 6px;
      }

      .file-list {
        padding: 6px;
      }

      .el-button--small {
        font-size: 8px
      }
    }

    @media screen and (max-width:575px) {
      .el-button--small {
        font-size: 2px
      }
    }

    .custom-tree-node {
      flex: 1;
      display: flex;
      align-items: center;
    }

    /* Tree node hover effect */
    .el-tree-node__wrapper:hover {
      background-color: #f5f7fa;
    }

    /* Selected tree node */
    .el-tree-node.is-current>.el-tree-node__content>.el-tree-node__wrapper {
      background-color: #f0e6fc !important;
      color: #8446df;
    }

    /* Right-click menu style optimization */
    .file-card-context-menu {
      position: fixed;
      background: white;
      border: 1px solid #EBEEF5;
      border-radius: 4px;
      box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
      z-index: 3000;
      min-width: 160px;
      padding: 5px 0;
    }

    .file-card-context-menu li {
      padding: 8px 16px;
      cursor: pointer;
      font-size: 14px;
      display: flex;
      align-items: center;
      transition: all 0.3s;
    }

    .file-card-context-menu li:hover {
      background-color: #f0e6fc;
      color: #8446df;
    }

    /* Drag related styles */
    .el-tree-node.is-dragging {
      opacity: 0.5;
      cursor: move;
    }

    /* Drag target highlight styles */
    .el-tree-node.is-drop-inner>.el-tree-node__content {
      background-color: #f0e6fc !important;
      border: 2px dashed #8446df !important;
      animation: dropTarget 1s ease infinite;
    }

    /* Ensure animation effect continues to display */
    @keyframes dropTarget {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.02);
      }

      100% {
        transform: scale(1);
      }
    }

    /* Prevent other hover effects from overriding drag styles */
    .el-tree-node.is-drop-inner>.el-tree-node__content:hover {
      background-color: #f0e6fc !important;
    }

    /* Ensure drag style priority */
    .el-tree-node.is-drop-inner {
      z-index: 100;
    }

    /* Folder tree container styles */
    .folder-tree-container {
      height: 100%;
      position: relative;
    }

    /* Root directory drag highlight styles */
    .folder-tree-container.drag-over {
      background-color: #f0e6fc;
      border: 2px dashed #8446df;
      border-radius: 4px;
      animation: dropTarget 1s ease infinite;
    }

    /* Folder node drag highlight styles */
    .el-tree-node.drag-over>.el-tree-node__content {
      background-color: #f0e6fc !important;
      border: 2px dashed #8446df;
      animation: dropTarget 1s ease infinite;
    }

    @keyframes dropTarget {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.02);
      }

      100% {
        transform: scale(1);
      }
    }

    /* Folder tree container styles */
    .folder-tree-container {
      height: 100%;
      position: relative;
    }

    /* Root directory drag highlight styles */
    .folder-tree-container.is-drop-target {
      background-color: #f0e6fc !important;
      border: 2px dashed #8446df !important;
      border-radius: 4px;
      animation: dropTarget 1s ease infinite;
    }

    /* Folder node drag highlight styles */
    .el-tree-node.is-drop-target>.el-tree-node__content {
      background-color: #f0e6fc !important;
      border: 2px dashed #8446df !important;
      animation: dropTarget 1s ease infinite;
    }

    /* Ensure highlight style priority */
    .el-tree-node.is-drop-target>.el-tree-node__content:hover {
      background-color: #f0e6fc !important;
    }

    @keyframes dropTarget {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.02);
      }

      100% {
        transform: scale(1);
      }
    }
  </style>
@endpush

@section('content')
  <div id="app">
    <div class="file-manager">
      <div class="file-toolbar">
        <el-row type="flex" justify="space-between" align="middle">
          <el-col :span="12">
            <el-button-group>
              <el-button type="primary" size="small" @click="uploadFile">
                <i class="el-icon-upload2"></i> Upload File
              </el-button>
              <el-button size="small" @click="createFolder">
                <i class="el-icon-folder-add"></i> New Folder
              </el-button>
              <el-button size="small" data-bs-toggle="modal" data-bs-target="#storageConfigModal">
                <i class="el-icon-setting"></i> {{ __('panel/file_manager.storage_config') }}
              </el-button>
              <el-button size="small" :type="isMultiSelectMode ? 'primary' : 'default'" @click="toggleMultiSelectMode">
                <i class="el-icon-check"></i> Multi-select Mode
              </el-button>
              <el-button v-if="isMultiSelectMode" size="small" @click="selectAll">
                <i class="el-icon-finished"></i> Select All
              </el-button>

              <el-button type="primary" size="small"@click="handleConfirm">Select and Submit</el-button>

            </el-button-group>
          </el-col>
          <el-col :span="12" style="text-align: right">
            <el-button-group>
              <el-button size="small" :disabled="selectedFiles.length !== 1" @click="renameSelectedFile">
                <i class="el-icon-edit"></i> Rename
              </el-button>
              <el-button size="small" :disabled="!selectedFiles.length" @click="deleteFiles">
                <i class="el-icon-delete"></i> Delete
              </el-button>
              <el-button size="small" :disabled="!selectedFiles.length" @click="moveFiles">
                <i class="el-icon-folder"></i> Move To
              </el-button>
              <el-button size="small" :disabled="!selectedFiles.length" @click="copyFiles">
                <i class="el-icon-document-copy"></i> Copy To
              </el-button>
            </el-button-group>
          </el-col>
        </el-row>
      </div>
      <el-row :gutter="0">
        <!-- Left folder tree -->
        <el-col :xs="8" :sm="6" :md="5" :lg="4"
          :xl="3">
          <div class="folder-tree">
            <el-tree ref="folderTree" :data="folders" :props="defaultProps" @node-click="handleNodeClick"
              :highlight-current="true" :default-expanded-keys="defaultExpandedKeys"
              :current-node-key="currentFolder ? currentFolder.id : '/'" node-key="id" draggable
              :allow-drop="handleAllowDrop" :allow-drag="handleAllowDrag" @node-drag-start="handleDragStart"
              @node-drag-enter="handleDragEnter" @node-drag-leave="handleDragLeave" @node-drag-end="handleNodeDragEnd"
              @node-drop="handleNodeDrop" class="folder-tree-container">
              <div class="el-tree-node__wrapper" slot-scope="{ node, data }"
                @contextmenu.prevent="showFolderContextMenu($event, data, node)" @dragover.prevent
                @dragenter.prevent="handleTreeDragEnter($event, node, data)"
                @dragleave.prevent="handleTreeDragLeave($event, node)" @drop.prevent="handleTreeDrop($event, node, data)">
                <span class="custom-tree-node">
                  <i :class="[
                      data.isRoot ? 'el-icon-folder' : 'el-icon-folder',
                      node.expanded ? 'el-icon-folder-opened' : 'el-icon-folder'
                  ]"
                    style="margin-right: 4px; color: #8446df;"></i>
                  <span>@{{ node.label }}</span>
                </span>
              </div>
            </el-tree>
          </div>
        </el-col>
        <!-- Right file list -->
        <el-col :xs="16" :sm="18" :md="19" :lg="20"
          :xl="21">
          <div class="file-list">
            <div class="file-list-content">
              <div v-loading="loading" element-loading-text="Loading...">
                <el-row :gutter="20">
                  <el-col :xs="12" :sm="8" :md="6" :lg="4"
                    :xl="4" :xl="3" v-for="file in files" :key="file.id || file.path">
                    <div :class="['file-card', selectedFiles.includes(file.id || file.path) ? 'selected' : '']"
                      @click="handleFileClick($event, file)" @dblclick="handleFileDoubleClick(file)"
                      @contextmenu.prevent="showContextMenu($event, file)" :data-is-dir="file.is_dir" draggable="true"
                      @dragstart="handleFileDragStart($event, file)" @dragend="handleFileDragEnd($event)"
                      @dragenter.prevent="handleFileDragEnter($event, file)" @dragover.prevent
                      @dragleave.prevent="handleFileDragLeave($event)" @drop.prevent="handleFileDrop($event, file)">
                      <div v-if="isMultiSelectMode" class="file-checkbox">
                        <el-checkbox :value="selectedFiles.includes(file.id || file.path)"
                          @click.native.stop="toggleFileSelect(file)">
                        </el-checkbox>
                      </div>
                      <div class="file-thumb">
                        <template v-if="file.is_dir">
                          <div class="folder-icon">
                            <img :src="file.thumb" alt="folder" class="folder-image"></img>
                          </div>
                        </template>
                        <template v-else>
                          <div class="file-thumb">
                            <div v-if="file.mime && file.mime.startsWith('image/')" class="preview-button"
                              @click.stop="$refs['image-' + file.id][0].clickHandler()">
                              Preview
                            </div>
                            <el-image :ref="'image-' + file.id" :src="file.url" :alt="file.name"
                              fit="contain" :preview-src-list="[file.url]">
                            </el-image>
                          </div>
                        </template>
                      </div>
                      <div class="file-info">
                        <p class="file-name" :title="file.name">@{{ file.name }}</p>
                        <p class="file-type">@{{ file.is_dir ? 'Folder' : file.mime }}</p>
                      </div>
                    </div>
                  </el-col>
                </el-row>
                <!-- Pagination -->
                <div class="pagination-container">
                  <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange"
                    :current-page="pagination.page" :page-sizes="[20, 40, 60, 80]" :page-size="pagination.per_page"
                    layout="total, sizes, prev, pager, next, jumper" :total="pagination.total">
                  </el-pagination>
                </div>
                <!-- Add empty state -->
                <el-empty v-else description="No files" :image-size="120"></el-empty>
              </div>
            </div>
          </div>
        </el-col>
      </el-row>
    </div>
    <!-- Create Folder Dialog -->
    <el-dialog title="Create Folder" :visible.sync="folderDialog.visible" width="400px">
      <el-form :model="folderDialog.form" label-width="80px">
        <el-form-item label="Folder Name">
          <el-input v-model="folderDialog.form.name" placeholder="Please enter folder name"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer">
        <el-button @click="folderDialog.visible = false">Cancel</el-button>
        <el-button type="primary" @click="submitCreateFolder">Confirm</el-button>
      </span>
    </el-dialog>

    <!-- Upload File Dialog -->
    <el-dialog title="Upload File" :visible.sync="uploadDialog.visible" width="500px">
      <el-upload class="file-uploader" drag multiple :action="uploadUrl" :headers="uploadHeaders"
        :data="uploadData" :before-upload="beforeUpload" :on-success="handleUploadSuccess"
        :on-error="handleUploadError" :on-progress="handleUploadProgress">
        <i class="el-icon-upload"></i>
        <div class="el-upload__text">Drag files here, or <em>click to upload</em></div>
        <div class="el-upload__tip" slot="tip">Supports jpg, jpeg, png, gif format image files</div>
      </el-upload>
    </el-dialog>

    <!-- Rename Dialog -->
    <el-dialog title="Rename" :visible.sync="renameDialog.visible" custom-class="rename-dialog" width="500px">
      <el-form :model="renameDialog.form" label-width="100px">
        <el-form-item label="File Name">
          <el-input v-model="renameDialog.form.newName" placeholder="Please enter new name">
            <template slot="append">.@{{ renameDialog.form.extension }}</template>
          </el-input>
        </el-form-item>
      </el-form>
      <span slot="footer">
        <el-button @click="renameDialog.visible = false">Cancel</el-button>
        <el-button type="primary" @click="submitRename">Confirm</el-button>
      </span>
    </el-dialog>

    <!-- Move File Dialog -->
    <el-dialog title="Move To" :visible.sync="moveDialog.visible" width="400px">
      <el-tree :data="folders" :props="defaultProps" @node-click="handleMoveTargetSelect"
        :highlight-current="true" node-key="id">
        <span class="custom-tree-node" slot-scope="{ node, data }">
          <i class="el-icon-folder" style="margin-right: 4px; color: #8446df;"></i>
          <span>@{{ node.label }}</span>
        </span>
      </el-tree>
      <span slot="footer">
        <el-button @click="moveDialog.visible = false">Cancel</el-button>
        <el-button type="primary" @click="submitMove">Confirm</el-button>
      </span>
    </el-dialog>

    <!-- File Card Context Menu -->
    <div class="file-card-context-menu" v-show="contextMenu.visible" :style="contextMenu.style">
      <ul>
        <li @click="renameFile"><i class="el-icon-edit"></i> Rename</li>
        <li @click="deleteFile"><i class="el-icon-delete"></i> Delete</li>
        <li @click="moveFile"><i class="el-icon-folder"></i> Move To</li>
        <li @click="copyFile"><i class="el-icon-document-copy"></i> Copy To</li>
      </ul>
    </div>

    <!-- Copy File Dialog -->
    <el-dialog title="Copy To" :visible.sync="copyDialog.visible" width="400px">
      <el-tree :data="folders" :props="defaultProps" @node-click="handleCopyTargetSelect"
        :highlight-current="true" node-key="id">
        <span class="custom-tree-node" slot-scope="{ node, data }">
          <i class="el-icon-folder" style="margin-right: 4px; color: #8446df;"></i>
          <span>@{{ node.label }}</span>
        </span>
      </el-tree>
      <span slot="footer">
        <el-button @click="copyDialog.visible = false">Cancel</el-button>
        <el-button type="primary" @click="submitCopy">Confirm</el-button>
      </span>
    </el-dialog>

    <!-- Folder Context Menu -->
    <div v-if="folderContextMenu.visible" class="file-card-context-menu"
      :style="{
          top: folderContextMenu.style.top,
          left: folderContextMenu.style.left
      }">
      <ul>
        <li @click="renameFolder">
          <i class="el-icon-edit"></i> Rename
        </li>
        <li @click="moveFolder">
          <i class="el-icon-position"></i> Move To
        </li>
        <li @click="deleteFolder">
          <i class="el-icon-delete"></i> Delete
        </li>
      </ul>
    </div>

    <!-- Folder Rename Dialog -->
    <el-dialog title="Rename Folder" :visible.sync="folderRenameDialog.visible" width="400px">
      <el-form :model="folderRenameDialog.form" label-width="80px">
        <el-form-item label="Folder Name">
          <el-input v-model="folderRenameDialog.form.newName" placeholder="Please enter new name"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer">
        <el-button @click="folderRenameDialog.visible = false">Cancel</el-button>
        <el-button type="primary" @click="submitFolderRename">Confirm</el-button>
      </span>
    </el-dialog>

    <!-- Folder Move Dialog -->
    <el-dialog title="Move Folder" :visible.sync="folderMoveDialog.visible" width="400px">
      <el-tree :data="folders" :props="defaultProps" @node-click="handleFolderMoveTargetSelect"
        :highlight-current="true" node-key="id">
        <span class="custom-tree-node" slot-scope="{ node, data }">
          <i class="el-icon-folder" style="margin-right: 4px; color: #8446df;"></i>
          <span>@{{ node.label }}</span>
        </span>
      </el-tree>
      <span slot="footer">
        <el-button @click="folderMoveDialog.visible = false">Cancel</el-button>
        <el-button type="primary" @click="submitFolderMove">Confirm</el-button>
      </span>
    </el-dialog>

    <!-- Storage Configuration Modal -->
    <div class="modal fade" id="storageConfigModal" tabindex="-1" aria-labelledby="storageConfigModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="storageConfigModalLabel">{{ __('panel/file_manager.storage_config') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="mb-3">
                <label class="form-label">{{ __('panel/file_manager.storage_type') }}</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="storageType" id="storageTypeLocal"
                    value="local" v-model="storageConfig.driver">
                  <label class="form-check-label" for="storageTypeLocal">
                    {{ __('panel/file_manager.local_storage') }}
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="storageType" id="storageTypeOSS"
                    value="oss" v-model="storageConfig.driver">
                  <label class="form-check-label" for="storageTypeOSS">
                    {{ __('panel/file_manager.alibaba_oss') }}
                  </label>
                </div>
              </div>

              <div v-if="storageConfig.driver === 'oss'">
                <div class="mb-3">
                  <label for="ossKey" class="form-label">{{ __('panel/file_manager.access_key') }}</label>
                  <input type="text" class="form-control" id="ossKey" v-model="storageConfig.key">
                </div>

                <div class="mb-3">
                  <label for="ossSecret" class="form-label">{{ __('panel/file_manager.secret_key') }}</label>
                  <input type="password" class="form-control" id="ossSecret" v-model="storageConfig.secret">
                </div>

                <div class="mb-3">
                  <label for="ossEndpoint" class="form-label">{{ __('panel/file_manager.endpoint') }}</label>
                  <input type="text" class="form-control" id="ossEndpoint" v-model="storageConfig.endpoint"
                    placeholder="Example: https://innoshop.oss-cn-hangzhou.aliyuncs.com">
                </div>

                <div class="mb-3">
                  <label for="ossBucket" class="form-label">{{ __('panel/file_manager.bucket') }}</label>
                  <input type="text" class="form-control" id="ossBucket" v-model="storageConfig.bucket">
                </div>

                <div class="mb-3">
                  <label for="ossRegion" class="form-label">{{ __('panel/file_manager.region') }}</label>
                  <input type="text" class="form-control" id="ossRegion" v-model="storageConfig.region"
                    placeholder="Example: cn-hangzhou">
                </div>

                <div class="mb-3">
                  <label for="ossCdnDomain" class="form-label">{{ __('panel/file_manager.cdn_domain') }} <small
                      class="text-muted">({{ __('panel/file_manager.optional') }})</small></label>
                  <input type="text" class="form-control" id="ossCdnDomain" v-model="storageConfig.cdn_domain"
                    placeholder="Example: https://cdn.example.com">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
              data-bs-dismiss="modal">{{ __('panel/common.cancel') }}</button>
            <button type="button" class="btn btn-primary"
              @click="saveStorageConfig">{{ __('panel/common.btn_save') }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('footer')
  <script>
    new Vue({
      el: '#app',
      created() {},
      mounted() {
        this.loadFiles();
        this.loadFolders();

        
        this.getStorageConfig();
      },
      data() {
        return {
          files: [],
          selectedFiles: [],
          currentFolder: null,
          folders: [],
          defaultProps: {
            children: 'children',
            label: 'name'
          },
          folderDialog: {
            visible: false,
            form: {
              name: '',
              parent_id: ''
            }
          },
          pagination: {
            page: 1,
            per_page: 20,
            total: 0
          },
          loading: false,
          uploadDialog: {
            visible: false
          },
          uploadUrl: '/api/panel/file_manager/upload',
          uploadHeaders: {
            'Authorization': 'Bearer ' + document.querySelector('meta[name="api-token"]').getAttribute('content')
          },
          uploadData: {
            path: '/demo',
            type: 'images' // 默认上传路径
          },
          cropperOptions: {
            viewMode: 1,
            autoCropArea: 1, // 默认裁剪全图
            zoomable: true,
            cropBoxResizable: true,
            cropBoxMovable: true,
            dragMode: 'move',
            guides: true,
            center: true,
            highlight: false,
            background: true,
            modal: true
          },
          defaultExpandedKeys: ['/'], // 默认展开根节点
          renameDialog: {
            visible: false,
            form: {
              newName: '',
              extension: '', // 添加扩展名字段
              file: null
            }
          },
          moveDialog: {
            visible: false,
            targetPath: null
          },
          contextMenu: {
            visible: false,
            style: {
              top: '0px',
              left: '0px'
            },
            file: null
          },
          copyDialog: {
            visible: false,
            targetPath: null
          },
          isMultiSelectMode: false, // 多选模式状态
          folderContextMenu: {
            visible: false,
            style: {
              top: '0px',
              left: '0px'
            },
            folder: null
          },
          folderRenameDialog: {
            visible: false,
            form: {
              newName: '',
              folder: null
            }
          },
          folderMoveDialog: {
            visible: false,
            targetPath: null,
            folder: null
          },
          isDragging: false,
          isIframeMode: {{ json_encode($isIframe) }},
          fileType: '{{ $type }}',
          storageConfig: {
            driver: 'local',
            key: '',
            secret: '',
            endpoint: '',
            bucket: '',
            region: '',
            cdn_domain: ''
          },
        }
      },
      methods: {
        uploadFile() {
          this.uploadData.path = this.currentFolder ? this.currentFolder.id : '/demo';
          this.uploadDialog.visible = true;
        },
        createFolder() {
          this.folderDialog.visible = true;
        },
        submitCreateFolder() {
          if (!this.folderDialog.form.name) {
            this.$message.warning('Please enter folder name');
            return;
          }

          http.post('file_manager/directories', {
            name: this.folderDialog.form.name,
            parent_id: this.currentFolder ? this.currentFolder.path : '/'
          }).then(res => {
            if (res.success) {
              this.$message.success('Created successfully');
              this.folderDialog.visible = false;
              this.folderDialog.form.name = '';
              // Reload folder tree
              this.loadFolders();
            } else {
              this.$message.error(res.message || 'Creation failed');
            }
          }).catch(err => {
            this.$message.error('Creation failed: ' + err.message);
          });
        },
        deleteFiles() {
          if (!this.selectedFiles.length) return;

          this.$confirm('Confirm delete selected files?', 'Confirmation', {
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            type: 'warning'
          }).then(() => {
            const currentPath = this.currentFolder ? this.currentFolder.path : '/';
            // Get list of selected file names
            const fileNames = this.selectedFiles.map(fileId => {
              const file = this.files.find(f => f.id === fileId);
              return file ? file.name : null;
            }).filter(name => name !== null);

            http.delete('file_manager/files', {
              data: {
                path: currentPath,
                files: fileNames
              }
            }).then(res => {
              if (res.success) {
                this.$message.success('Deleted successfully');
                this.selectedFiles = [];
                this.loadFiles(currentPath);
              }
            });
          });
        },
        moveFiles() {
          if (!this.selectedFiles.length) return;
          this.moveDialog.visible = true;
        },
        copyFiles() {
          if (!this.selectedFiles.length) return;
          this.copyDialog.visible = true;
        },
        handleFileClick(event, file) {
          if (this.isDragging) return;

          if (this.isIframeMode && !file.is_dir) {
            if (window.fileManagerConfig.multiple) {
              this.toggleFileSelect(file);
            } else {
              window.parent.fileManagerCallback(file);
              parent.layer.closeAll();
            }
          } else {
            const fileId = file.id || file.path;
            const index = this.selectedFiles.indexOf(fileId);

            // If it's a folder, maintain single selection mode
            if (file.is_dir) {
              if (index === -1) {
                this.selectedFiles = [fileId];
              } else {
                this.selectedFiles = [];
              }
            } else {
              // If it's a file, only remove current file from selection list
              if (index !== -1) {
                this.selectedFiles.splice(index, 1);
              } else {
                this.selectedFiles.push(fileId);
              }
            }
          }
        },
        handleNodeClick(data) {
          this.currentFolder = data;
          this.loadFiles(data.path);
        },
        loadFiles(path = null) {
          this.loading = true;
          const currentPath = path !== null ? path : (this.currentFolder ? this.currentFolder.path : '/');
          
          const params = {
            page: this.pagination.page,
            per_page: this.pagination.per_page,
            base_folder: currentPath
          };

          http.get('file_manager/files', {
              params
            })
            .then(res => {
              // Process file list data

              this.files = res.images.map(file => ({
                ...file,
                id: file.id || file.path, // Ensure each file has unique identifier
                selected: false,
                preview_url: file.url, // Save preview URL
                url: file.path ? file.path : file.url // Actual file path
              }));

              // Update pagination info
              this.pagination.total = res.image_total;
              this.pagination.page = res.image_page;
            })
            .catch(err => {
              this.$message.error('Failed to get file list: ' + err.message);
            })
            .finally(() => {
              this.loading = false;
            });
        },

        handleCurrentChange(page) {
          this.pagination.page = page;
          this.loadFiles();
        },

        handleSizeChange(size) {
          this.pagination.per_page = size;
          this.pagination.page = 1;
          this.loadFiles();
        },

        beforeUpload(file) {
          const isImage = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'].includes(file.type);
          const isVideo = ['video/mp4', 'video/webm', 'video/ogg'].includes(file.type)
          const isDoc = ['application/pdf', 'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
          ].includes(file.type)
          if (!isImage && !isVideo && !isDoc) {
            this.$message.error('Only image or video files can be uploaded!');
            return false;
          }

          const isLt2M = file.size / 1024 / 1024 < 8;
          if (!isLt2M) {
            this.$message.error('File size cannot exceed 8MB!');
            return false;
          }
          if (isVideo || isDoc) {
            const formData = new FormData();
            if (isVideo) {
              formData.append('file', file);
              formData.append('path', this.uploadData.path);
              formData.append('type', 'videos');
            } else {
              formData.append('file', file);
              formData.append('path', this.uploadData.path);
              formData.append('type', 'application');
            }
            http.post('file_manager/upload', formData)
              .then(res => {
                if (res.success) {
                  this.$message.success('Upload successful');
                  this.uploadDialog.visible = false;
                  this.loadFiles();
                } else {
                  this.$message.error(res.message || 'Upload failed');
                }
              })
              .catch(err => {
                this.$message.error('Upload failed: ' + err.message);
              });
            return false;
          } else {
            this.cropImage(file);
            return false;
          }
        },

        cropImage(file) {
          const reader = new FileReader();
          reader.onload = (e) => {
            // Create mask layer
            const mask = document.createElement('div');
            mask.className = 'cropper-mask';
            document.body.appendChild(mask);

            // Create crop dialog
            const dialog = document.createElement('div');
            dialog.className = 'cropper-dialog';
            dialog.innerHTML = `
          <div class="cropper-container">
            <img src="${e.target.result}">
          </div>
          <div class="cropper-controls">
            <button class="el-button el-button--default el-button--small cancel-btn">Cancel</button>
            <button class="el-button el-button--primary el-button--small confirm-btn">Confirm</button>
          </div>
        `;

            document.body.appendChild(dialog);

            // Initialize cropper
            const image = dialog.querySelector('img');
            const cropper = new Cropper(image, this.cropperOptions);

            // Confirm crop
            dialog.querySelector('.confirm-btn').onclick = () => {
              const canvas = cropper.getCroppedCanvas({
                width: 800,
                height: 800
              });

              canvas.toBlob((blob) => {
                const formData = new FormData();
                formData.append('file', blob, file.name);
                formData.append('path', this.uploadData.path);
                formData.append('type', 'images');

                // Upload cropped image
                http.post('file_manager/upload', formData)
                  .then(res => {
                    if (res.success) {
                      this.$message.success('Upload successful');

                      this.cleanupDialog(dialog, mask);

                      // Close upload dialog
                      this.uploadDialog.visible = false;

                      // Refresh file list
                      this.loadFiles();
                    } else {
                      this.$message.error(res.message || 'Upload failed');
                    }
                  })
                  .catch(err => {
                    this.$message.error('Upload failed: ' + err.message);
                  })
                  .finally(() => {
                    this.cleanupDialog(dialog, mask);
                    this.uploadDialog.visible = false;
                  });
              });
            };

            // Cancel crop
            dialog.querySelector('.cancel-btn').onclick = () => {
              this.cleanupDialog(dialog, mask);
            };
          };
          reader.readAsDataURL(file);
        },

        // Upload success callback
        handleUploadSuccess(response, file, fileList) {
          if (response.success) {
            this.$message.success('Upload successful');
            // Refresh file list
            this.loadFiles();
          } else {
            this.$message.error(response.message || 'Upload failed');
          }

          // If all files are uploaded, close dialog
          if (fileList.every(file => file.status === 'success' || file.status === 'error')) {
            this.uploadDialog.visible = false;
          }
        },

        // Upload error callback
        handleUploadError(err, file) {
          this.$message.error('Upload failed: ' + (err.message || 'Unknown error'));
        },

        // Upload progress callback
        handleUploadProgress(event, file) {

        },

        cleanupDialog(dialog, mask) {
          // Check and remove dialog
          if (dialog && dialog.parentNode) {
            dialog.parentNode.removeChild(dialog);
          }
          // Check and remove mask
          if (mask && mask.parentNode) {
            mask.parentNode.removeChild(mask);
          }
        },

        // Get folder tree
        loadFolders() {
          http.get('file_manager/directories').then(res => {
            const folders = Array.isArray(res.data) ? res.data : [];

            this.folders = [{
              id: '/',
              name: 'Image Space',
              path: '/',
              isRoot: true,
              children: folders.map(folder => ({
                id: folder.path,
                name: folder.name,
                path: folder.path,
                children: folder.children?.map(child => ({
                  id: child.path,
                  name: child.name,
                  path: child.path,
                  children: child.children || []
                })) || []
              }))
            }];

            // Default select root directory
            this.currentFolder = {
              id: '/',
              name: 'Image Space',
              path: '/'
            };

            // Set default expanded nodes
            this.defaultExpandedKeys = ['/'];

            // Load files in root directory
            this.loadFiles('/');
          }).catch(err => {
            this.$message.error('Failed to get folders: ' + err.message);
          });
        },

        // Rename file
        renameFile() {
          const file = this.contextMenu.file;
          this.renameDialog.form.file = file;
          // Separate filename and extension
          const extension = file.name.split('.').pop();
          const nameWithoutExt = file.name.slice(0, -(extension.length + 1));
          this.renameDialog.form.newName = nameWithoutExt;
          this.renameDialog.form.extension = extension;
          this.renameDialog.visible = true;
          this.hideContextMenu();
        },

        
// Rename selected file
renameSelectedFile() {
  if (this.selectedFiles.length !== 1) return;

  const selectedFile = this.files.find(file => file.id === this.selectedFiles[0]);
  if (selectedFile) {
    this.renameDialog.form.file = selectedFile;
    // Separate filename and extension
    const extension = selectedFile.name.split('.').pop();
    const nameWithoutExt = selectedFile.name.slice(0, -(extension.length + 1));
    this.renameDialog.form.newName = nameWithoutExt;
    this.renameDialog.form.extension = extension;
    this.renameDialog.visible = true;
  }
},

// Submit rename
submitRename() {
  if (!this.renameDialog.form.newName) {
    this.$message.warning('Please enter a new name');
    return;
  }

  const file = this.renameDialog.form.file;
  const currentPath = this.currentFolder ? this.currentFolder.path : '/';
  // Combine new filename
  const newFullName = `${this.renameDialog.form.newName}.${this.renameDialog.form.extension}`;

  http.post('file_manager/rename', {
    origin_name: currentPath + '/' + file.name,
    new_name: newFullName
  }).then(res => {
    if (res.success) {
      this.$message.success('Rename successful');
      this.renameDialog.visible = false;
      this.loadFiles(currentPath);
    }
  });
},

// Delete single file
deleteFile() {
  const file = this.contextMenu.file;
  this.$confirm('Confirm delete this file?', 'Tip', {
    confirmButtonText: 'Confirm',
    cancelButtonText: 'Cancel',
    type: 'warning'
  }).then(() => {
    const currentPath = this.currentFolder ? this.currentFolder.path : '/';
    http.delete('file_manager/files', {
      data: {
        path: currentPath,
        files: [file.name]
      }
    }).then(res => {
      if (res.success) {
        this.$message.success('Delete successful');
        this.selectedFiles = [];
        this.loadFiles(currentPath);
      }
    });
  });
  this.hideContextMenu();
},

// Move file
moveFile() {
  const file = this.contextMenu.file;
  // Maintain single selection state
  this.selectedFiles = [file.id || file.path];
  this.moveDialog.visible = true;
  this.hideContextMenu();
},

// Select move target folder
handleMoveTargetSelect(data) {
  this.moveDialog.targetPath = data.path;
},

// Submit move
submitMove() {
  if (!this.moveDialog.targetPath) {
    this.$message.warning('Please select target folder');
    return;
  }

  // Get full path of selected files
  const currentPath = this.currentFolder ? this.currentFolder.path : '/';
  const files = this.selectedFiles.map(fileId => {
    const file = this.files.find(f => f.id === fileId);
    return currentPath + '/' + file.name;
  });

  http.post('file_manager/move_files', {
    files: files,
    dest_path: this.moveDialog.targetPath
  }).then(res => {
    if (res.success) {
      this.$message.success('Move successful');
      this.moveDialog.visible = false;
      this.selectedFiles = [];
      this.loadFiles(currentPath);
    }
  });
},

// Show context menu
showContextMenu(event, file) {
  event.preventDefault();
  // Clear previous selection and select current file on right click
  this.selectedFiles = [file.id || file.path];

  this.contextMenu.visible = true;
  this.contextMenu.style.top = event.clientY + 'px';
  this.contextMenu.style.left = event.clientX + 'px';
  this.contextMenu.file = file;

  // Close menu when clicking elsewhere
  document.addEventListener('click', this.hideContextMenu);
},

// Hide context menu
hideContextMenu() {
  this.contextMenu.visible = false;
  document.removeEventListener('click', this.hideContextMenu);
},

// Copy single file
copyFile() {
  const file = this.contextMenu.file;
  // Maintain single selection state
  this.selectedFiles = [file.id || file.path];
  this.copyDialog.visible = true;
  this.hideContextMenu();
},

// Batch copy files
copyFiles() {
  if (!this.selectedFiles.length) return;
  this.copyDialog.visible = true;
},

// Submit copy
submitCopy() {
  if (!this.copyDialog.targetPath) {
    this.$message.warning('Please select target folder');
    return;
  }

  // Get full path of selected files
  const currentPath = this.currentFolder ? this.currentFolder.path : '/';
  const files = this.selectedFiles.map(fileId => {
    const file = this.files.find(f => f.id === fileId);
    return currentPath + '/' + file.name;
  });

  http.post('file_manager/copy_files', {
    files: files,
    dest_path: this.copyDialog.targetPath
  }).then(res => {
    if (res.success) {
      this.$message.success('Copy successful');
      this.copyDialog.visible = false;
      this.selectedFiles = [];
      this.loadFiles(currentPath);
    }
  });
},

// Add method for selecting target folder
handleCopyTargetSelect(data) {
  this.copyDialog.targetPath = data.path;
},

// Toggle multi-select mode
toggleMultiSelectMode() {
  this.isMultiSelectMode = !this.isMultiSelectMode;
  if (!this.isMultiSelectMode) {
    // Clear selection when exiting multi-select mode
    this.selectedFiles = [];
  }
},

// Toggle file selection state
toggleFileSelect(file) {
  const fileId = file.id || file.path;
  const index = this.selectedFiles.indexOf(fileId);
  if (index === -1) {
    this.selectedFiles.push(fileId);
  } else {
    this.selectedFiles.splice(index, 1);
  }
},
       // Show folder context menu
showFolderContextMenu(event, data, node) {
  if (data.isRoot) return; // Don't show context menu for root node

  event.preventDefault();
  this.folderContextMenu.visible = true;
  this.folderContextMenu.style.top = event.clientY + 'px';
  this.folderContextMenu.style.left = event.clientX + 'px';
  this.folderContextMenu.folder = data;

  // Close menu when clicking elsewhere
  document.addEventListener('click', this.hideFolderContextMenu);
},

// Hide folder context menu
hideFolderContextMenu() {
  this.folderContextMenu.visible = false;
  document.removeEventListener('click', this.hideFolderContextMenu);
},

// Rename folder
renameFolder() {
  const folder = this.folderContextMenu.folder;
  this.folderRenameDialog.form.folder = folder;
  this.folderRenameDialog.form.newName = folder.name;
  this.folderRenameDialog.visible = true;
  this.hideFolderContextMenu();
},

// Submit folder rename
submitFolderRename() {
  if (!this.folderRenameDialog.form.newName) {
    this.$message.warning('Please enter a new name');
    return;
  }

  const folder = this.folderRenameDialog.form.folder;
  http.post('file_manager/rename', {
    origin_name: folder.path,
    new_name: this.folderRenameDialog.form.newName
  }).then(res => {
    if (res.success) {
      this.$message.success('Rename successful');
      this.folderRenameDialog.visible = false;
      // Reload folder tree
      this.loadFolders();
    }
  });
},

// Delete folder
deleteFolder() {
  const folder = this.folderContextMenu.folder;
  this.$confirm('Confirm delete this folder?', 'Tip', {
    confirmButtonText: 'Confirm',
    cancelButtonText: 'Cancel',
    type: 'warning'
  }).then(() => {
    http.delete('file_manager/directories', {
      data: {
        name: folder.path
      }
    }).then(res => {
      if (res.success) {
        this.$message.success('Delete successful');
        this.loadFolders();
      }
    });
  });
  this.hideFolderContextMenu();
},

// Show move folder dialog
moveFolder() {
  const folder = this.folderContextMenu.folder;
  this.folderMoveDialog.folder = folder;
  this.folderMoveDialog.visible = true;
  this.hideFolderContextMenu();
},

// Select target folder
handleFolderMoveTargetSelect(data) {
  // Cannot move to itself or its subfolders
  if (data.path === this.folderMoveDialog.folder.path ||
    data.path.startsWith(this.folderMoveDialog.folder.path + '/')) {
    this.$message.warning('Cannot move to itself or its subfolders');
    return;
  }
  this.folderMoveDialog.targetPath = data.path;
},

// Submit folder move
submitFolderMove() {
  if (!this.folderMoveDialog.targetPath) {
    this.$message.warning('Please select target folder');
    return;
  }

  const folder = this.folderMoveDialog.folder;
  http.post('file_manager/move_directories', {
    source_path: folder.path,
    dest_path: this.folderMoveDialog.targetPath
  }).then(res => {
    if (res.success) {
      this.$message.success('Move successful');
      this.folderMoveDialog.visible = false;
      // Reload folder tree
      this.loadFolders();
    }
  });
},

// Handle file double click
handleFileDoubleClick(file) {
  if (file.is_dir) {
    // If it's a folder, enter that folder
    const currentPath = this.currentFolder ? this.currentFolder.path : '/';
    const targetPath = currentPath === '/' ?
      '/' + file.name :
      currentPath + '/' + file.name;

    this.currentFolder = {
      id: targetPath,
      name: file.name,
      path: targetPath
    };

    // Add current path to expanded nodes
    if (!this.defaultExpandedKeys.includes(targetPath)) {
      this.defaultExpandedKeys.push(targetPath);
    }

    // Load target folder content
    this.loadFiles(targetPath);

    // Sync left tree selection state
    this.$nextTick(() => {
      const treeComponent = this.$refs.folderTree;
      if (treeComponent) {
        treeComponent.setCurrentKey(targetPath);
      }
    });
  } else {
    // If it's an image file
    const mainApp = document.querySelector('#app').__vue__;
    if (mainApp && typeof mainApp.confirmSelection === 'function') {
      mainApp.confirmSelection();
    }
  }
},

// Handle drag end
handleDragEnd(evt) {
  const draggedFile = this.files[evt.oldIndex];
  const targetFolder = evt.to.dataset.path;

  if (targetFolder && draggedFile) {
    // Move files to target folder
    this.moveFilesToFolder([draggedFile], targetFolder);
  }
},

// Move files to folder
moveFilesToFolder(files, targetPath) {
  const currentPath = this.currentFolder ? this.currentFolder.path : '/';
  const fileNames = files.map(file => currentPath + '/' + file.name);

  http.post('file_manager/move_files', {
    files: fileNames,
    dest_path: targetPath
  }).then(res => {
    if (res.success) {
      this.$message.success('Move successful');
      this.loadFiles(currentPath);
    }
  });
},

// Handle tree node drop
handleNodeDrop(draggingNode, dropNode, type) {
  if (type !== 'inner') return;

  const sourcePath = draggingNode.data.path;
  const targetPath = dropNode.data.path;

  // Check if dropping to current folder
  const sourceDir = this.getParentPath(sourcePath);
  if (sourcePath === targetPath || sourceDir === targetPath) {
    // If dropping to current folder, return without request
    return;
  }

  http.post('file_manager/move_directories', {
    source_path: sourcePath,
    dest_path: targetPath
  }).then(res => {
    if (res.success) {
      this.$message.success('Move successful');
      this.loadFolders();
      if (this.currentFolder && this.currentFolder.path === sourcePath) {
        this.loadFiles(targetPath);
      }
    }
  }).catch(err => {
    this.loadFolders();
    this.$message.error(err.message || 'Move failed');
  });
},

// Check if drop is allowed
handleAllowDrop(draggingNode, dropNode, type) {
  // Safety check
  if (!draggingNode || !dropNode) return false;

  // Handle file drop
  if (!draggingNode.data) {
    return type === 'inner';
  }

  // Handle folder drop
  if (dropNode.data.isRoot) {
    return type === 'inner';
  }
  if (draggingNode.data.path === dropNode.data.path) return false;
  if (dropNode.data.path.startsWith(draggingNode.data.path + '/')) return false;
  return type === 'inner';
},

// Check if node can be dragged
handleAllowDrag(node) {
  // Root node cannot be dragged
  return !node.data.isRoot;
},

// Handle drag end
handleNodeDragEnd(draggingNode, dropNode) {
  // Use nextTick to ensure DOM updates are complete
  this.$nextTick(() => {
    // Clean up all drag-related styles
    document.querySelectorAll('.el-tree-node').forEach(node => {
      node.classList.remove('is-dragging', 'is-drop-inner');
    });
  });

  // If drop was not successful, reload folder tree
  if (!dropNode) {
    this.loadFolders();
  }
},

// On drag start
handleDragStart(node) {
  if (node && node.$el) {
    node.$el.classList.add('is-dragging');
  }
},

       //last add
       // When entering droppable target
        handleDragEnter(draggingNode, dropNode) {
          // Safety check
          if (!dropNode || !dropNode.$el) return;

          if (this.handleAllowDrop(draggingNode, dropNode, 'inner')) {
            // Remove drag styles from all other nodes
            document.querySelectorAll('.el-tree-node').forEach(node => {
              node.classList.remove('is-drop-inner');
            });
            // Add drag style to current node
            dropNode.$el.classList.add('is-drop-inner');
          }
        },

        // When leaving drop target
        handleDragLeave(draggingNode, dropNode) {
          // Add safety check
          if (!dropNode || !dropNode.$el) return;

          dropNode.$el.classList.remove('is-drop-inner');
        },

        // File drag start
        handleFileDragStart(event, file) {
          this.isDragging = true;
          this.draggedFile = file;
          event.dataTransfer.effectAllowed = 'move';
          event.target.classList.add('dragging');
        },

        // File dragging
        handleFileDrag(event) {
          // Can add visual effects during dragging
        },

        // File drag end
        handleFileDragEnd(event) {
          this.isDragging = false;
          this.draggedFile = null;
          event.target.classList.remove('dragging');
          document.querySelectorAll('.file-card').forEach(card => {
            card.classList.remove('drag-over');
          });
        },
        handleConfirm() {
          // Get main Vue instance and call its method
          const mainApp = document.querySelector('#app').__vue__;
          if (mainApp && typeof mainApp.confirmSelection === 'function') {
            mainApp.confirmSelection();
          }
        },
        // Tree node receives drag enter
        handleTreeDragEnter(event, node, data) {
          if (!this.isDragging || !this.draggedFile) return;

          // Folder drag check if it's the same folder
          if (this.draggedFile.is_dir) {
            // Get complete path of currently dragged folder
            const draggedPath = this.currentFolder.path + '/' + this.draggedFile.name;

            // If dragging to itself or its parent folder, return directly
            if (draggedPath === data.path || data.path.startsWith(draggedPath + '/')) {
              return;
            }

            // If dragging to current folder, return directly
            if (data.path === this.currentFolder.path) {
              return;
            }
          }

          // Clear all highlight styles
          document.querySelectorAll('.el-tree-node').forEach(node => {
            node.classList.remove('is-drop-target');
          });
          this.$refs.folderTree.$el.classList.remove('is-drop-target');

          if (data.isRoot) {
            // If it's root directory, highlight entire tree container
            this.$refs.folderTree.$el.classList.add('is-drop-target');
          } else {
            // If it's normal folder, highlight current node
            const treeNode = event.target.closest('.el-tree-node');
            if (treeNode) {
              treeNode.classList.add('is-drop-target');
            }
          }
        },

        // Handle tree node drag leave
        handleTreeDragLeave(event, node) {
          // Check if mouse really left the target element and its children
          const relatedTarget = event.relatedTarget;
          const currentTarget = event.currentTarget;

          if (!currentTarget.contains(relatedTarget)) {
            const treeNode = event.target.closest('.el-tree-node');
            if (treeNode) {
              treeNode.classList.remove('is-drop-target');
            }
            // Remove root directory highlight
            this.$refs.folderTree.$el.classList.remove('is-drop-target');
          }
        },

        // Handle tree node drop
        handleTreeDrop(event, node, data) {
          // Remove all highlight styles
          document.querySelectorAll('.el-tree-node').forEach(node => {
            node.classList.remove('is-drop-target');
          });
          this.$refs.folderTree.$el.classList.remove('is-drop-target');

          // If it's a file dragged from the right side
          if (this.isDragging && this.draggedFile) {
            const currentPath = this.currentFolder ? this.currentFolder.path : '/';
            const targetPath = data.path;

            // Check if dropping to current folder
            if (currentPath === targetPath) {
              this.isDragging = false;
              this.draggedFile = null;
              return;
            }

            // If it's a folder and the dragged item is also a folder, check if it's the same folder
            if (this.draggedFile.is_dir) {
              // Get complete path of currently dragged folder
              const draggedPath = currentPath + '/' + this.draggedFile.name;

              // If dragging to itself or its parent folder, return directly
              if (draggedPath === targetPath || targetPath.startsWith(draggedPath + '/')) {
                this.isDragging = false;
                this.draggedFile = null;
                return;
              }
            }

            const files = [currentPath + '/' + this.draggedFile.name];

            http.post('file_manager/move_files', {
              files: files,
              dest_path: targetPath
            }).then(res => {
              if (res.success) {
                this.$message.success('Move successful');
                this.loadFiles(currentPath);
              }
            }).catch(err => {
              this.$message.error(err.message || 'Move failed');
            }).finally(() => {
              this.isDragging = false;
              this.draggedFile = null;
            });
            return;
          }

          // Handle folder tree internal dragging
          if (node && data) {
            const sourcePath = node.data.path;
            const targetPath = data.path;

            // Check if dropping to current folder
            const sourceDir = this.getParentPath(sourcePath);
            if (sourcePath === targetPath || sourceDir === targetPath) {
              return;
            }

            http.post('file_manager/move_directories', {
              source_path: sourcePath,
              dest_path: targetPath
            }).then(res => {
              if (res.success) {
                this.$message.success('Move successful');
                this.loadFolders();
                if (this.currentFolder && this.currentFolder.path === sourcePath) {
                  this.loadFiles(targetPath);
                }
              }
            }).catch(err => {
              this.loadFolders();
              this.$message.error(err.message || 'Move failed');
            });
          }
        },

        // File drag enter target
        handleFileDragEnter(event, file) {
          // If target is not a folder, or it's itself, don't allow drag
          if (!this.isDragging || !this.draggedFile || !file.is_dir ||
            this.draggedFile.id === file.id ||
            this.draggedFile.path === file.path) {
            return;
          }

          const card = event.target.closest('.file-card');
          if (card) {
            // Clear styles from other folders
            document.querySelectorAll('.file-card').forEach(c => {
              c.classList.remove('drag-over');
            });
            // Add style to current folder
            card.classList.add('drag-over');
          }
        },

        // Add file drag leave target handler
        handleFileDragLeave(event) {
          const card = event.target.closest('.file-card');
          if (card) {
            card.classList.remove('drag-over');
          }
        },

        // File drop handler
        handleFileDrop(event, targetFile) {
          event.preventDefault();

          // If not in dragging state, or target is not a folder, or dragging to itself, return directly
          if (!this.isDragging || !this.draggedFile || !targetFile.is_dir ||
            this.draggedFile.id === targetFile.id ||
            this.draggedFile.path === targetFile.path) {
            this.isDragging = false;
            this.draggedFile = null;
            document.querySelectorAll('.file-card').forEach(card => {
              card.classList.remove('drag-over');
            });
            return;
          }

          const currentPath = this.currentFolder ? this.currentFolder.path : '/';
          const targetPath = currentPath === '/' ?
            '/' + targetFile.name :
            currentPath + '/' + targetFile.name;

          // Check if dropping within the same folder
          const draggedFilePath = this.draggedFile.path;
          const draggedFileDir = draggedFilePath.substring(0, draggedFilePath.lastIndexOf('/')) || '/';

          if (draggedFileDir === targetPath) {
            // If dropping within the same folder, return directly without moving
            this.isDragging = false;
            this.draggedFile = null;
            document.querySelectorAll('.file-card').forEach(card => {
              card.classList.remove('drag-over');
            });
            return;
          }

          const files = [currentPath + '/' + this.draggedFile.name];

          http.post('file_manager/move_files', {
            files: files,
            dest_path: targetPath
          }).then(res => {
            if (res.success) {
              this.$message.success('Move successful');
              this.loadFiles(currentPath);
            }
          }).catch(err => {
            this.$message.error(err.message || 'Move failed');
          }).finally(() => {
            this.isDragging = false;
            this.draggedFile = null;
            document.querySelectorAll('.file-card').forEach(card => {
              card.classList.remove('drag-over');
            });
          });
        },
        // Add helper method (if not already exists)
        getParentPath(path) {
          if (!path) return '/';
          const parts = path.split('/');
          parts.pop();
          return parts.join('/') || '/';
        },
        // Handle file selection
        handleFileSelect(file) {
          if (this.isIframeMode && window.parent.fileManagerCallback) {
            if (!this.isMultiSelectMode) {
              window.parent.fileManagerCallback(file);
              parent.layer.closeAll();
              return;
            }
            this.toggleFileSelect(file);
          }
        },
        // Confirm selection (multi-select mode)
        confirmSelection() {
          if (this.isIframeMode && window.parent.fileManagerCallback) {
            if (this.selectedFiles.length === 0) {
              this.$message.warning('Please select at least one file');
              return;
            }
            const selectedFiles = this.files.filter(file =>
              this.selectedFiles.includes(file.id || file.path)
            );
            if (window.fileManagerConfig.multiple) {
              // Multi-select mode: return array
              window.parent.fileManagerCallback(selectedFiles);
            } else {
              // Single-select mode: return single file
              window.parent.fileManagerCallback(selectedFiles[0]);
            }
            parent.layer.closeAll();
          }
        },
        saveStorageConfig() {
          axios.post('/api/panel/file_manager/storage_config', this.storageConfig)
            .then(response => {
              if (response.data && response.success) {
                layer.msg(response.message, {
                  icon: 1
                });
                // Get modal instance and close
                const modal = bootstrap.Modal.getInstance(document.getElementById('storageConfigModal'));
                if (modal) {
                  modal.hide();
                }
                // Refresh page to apply new configuration
                setTimeout(() => {
                  window.location.reload();
                }, 1500);
              } else {
                layer.msg(response.data ? response.message : 'Save failed', {
                  icon: 2
                });
              }
            })
            .catch(error => {
              console.error('Failed to save storage configuration:', error);
              layer.msg(error.response?.message || 'Save failed', {
                icon: 2
              });
            });
        },

        // Get storage configuration
        getStorageConfig() {
          axios.get('/api/panel/file_manager/storage_config')
            .then(response => {
              if (response.data && response.success) {
                this.storageConfig = response.data;
              } else {
                // Set default values
                this.storageConfig = {
                  driver: 'local',
                  key: '',
                  secret: '',
                  endpoint: '',
                  bucket: '',
                  region: '',
                  cdn_domain: ''
                };
              }
            })
            .catch(error => {
              console.error('Failed to get storage configuration request:', error);
              // Set default values
              this.storageConfig = {
                driver: 'local',
                key: '',
                secret: '',
                endpoint: '',
                bucket: '',
                region: '',
                cdn_domain: ''
              };
            });
        },
      },
      beforeDestroy() {
        document.removeEventListener('click', this.hideContextMenu);
        document.removeEventListener('click', this.hideFolderContextMenu);
      }
    });
  </script>
@endpush