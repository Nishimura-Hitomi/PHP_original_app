<?php
namespace Poa\Controller;
class CommentCsv extends \Poa\Controller {
  public function outputCsv($thread_id){
    try {
      $threadModel = new \Poa\Model\Thread();
      $data = $threadModel->getThreadCsv($thread_id);
      $csv = array('username','title','body','date');
      $csv = mb_convert_encoding($csv,'SJIS-WIN','UTF-8');
      $date = date("YmdH:i:s");
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename='. $date .'_thread.csv');
      $stream = fopen('php://output', 'w');
      stream_filter_prepend($stream,'convert.iconv.utf-8/cp932');
      $i = 0;
      foreach ($data as $row) {
        if($i === 0) {
          fputcsv($stream , $csv);
        }
        fputcsv($stream , $row);
        $i++;
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }
}