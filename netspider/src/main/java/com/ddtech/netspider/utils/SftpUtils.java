package com.ddtech.netspider.utils;


import cn.hutool.core.util.StrUtil;
import cn.hutool.extra.ssh.ChannelType;
import cn.hutool.extra.ssh.JschUtil;
import cn.hutool.http.HttpUtil;
import com.jcraft.jsch.*;
import org.springframework.beans.factory.annotation.Value;

import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Arrays;

public class SftpUtils {
    public static String HOST = "183.238.147.82";
    public static int PORT = 22;
    public static String USERNAME = "root";

    public static String PASSWORD = "@ddtechinfo@2021";

    public ChannelSftp channelSftp = null;

    public Session sshSession = null;


    public void upload( String urlStr, String downloadRoot) throws Exception {

        URL url = new URL(urlStr);
        HttpURLConnection conn = (HttpURLConnection) url.openConnection();
        //设置请求方式为"GET"
        conn.setRequestMethod("GET");
        //超时响应时间为10秒
        conn.setConnectTimeout(10 * 1000);
        //通过输入流获取图片数据
        InputStream is = conn.getInputStream();
        String fullPath = downloadRoot + url.getPath();
        String fileNameAbsolute = fullPath.replaceAll("\\\\", "/");
        String remoteDirectory = fileNameAbsolute.substring(0, fileNameAbsolute.lastIndexOf("/"));
        this.channelSftp=getChannelSftp();
        boolean dirs = createDirs(remoteDirectory, channelSftp);
        if (!dirs) {
            throw new Exception("Can not create dir:" + remoteDirectory);
        }
        channelSftp.put(is, fullPath);
        logoutSftp();
        is.close();
        conn.disconnect();

    }


    private static boolean createDirs(String dirPath, ChannelSftp sftp) {
        if (StrUtil.isNotBlank(dirPath)) {
            String[] dirs = Arrays.stream(dirPath.split("/")).filter(StrUtil::isNotBlank).toArray(String[]::new);
            for (String dir : dirs) {
                try {
                    sftp.cd(dir);
                } catch (Exception e) {
                    try {
                        sftp.mkdir(dir);
                    } catch (SftpException e1) {
                        e1.printStackTrace();
                        return false;
                    }
                    try {
                        sftp.cd(dir);
                    } catch (SftpException e1) {
                        e1.printStackTrace();
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }


    public static void mkdirs(ChannelSftp sftpChannel, String remoteDirectory) throws Exception {
        try {
            sftpChannel.cd(remoteDirectory);
        } catch (SftpException e) {
            String[] dirs = remoteDirectory.replaceAll("\\\\", "/").split("/"); //{abc,sdf,sdf,adf}
            String tempPath = "";
            for (String dir : dirs) {
                if (StrUtil.isEmpty(dir)) {
                    continue;
                }

                //此处不能使用File.separator
                tempPath += "/" + dir;
                try {
                    sftpChannel.cd(tempPath);
                } catch (SftpException sftpException) {
                    try {
                        sftpChannel.mkdir(tempPath);
                        sftpChannel.cd(tempPath);
                    } catch (Exception exception) {
                        throw exception;
                    }
                }
            }
        }
        try {
            sftpChannel.cd(remoteDirectory.replaceAll("\\\\", "/"));
        } catch (SftpException e) {
            throw e;
        }
    }

//    public static ChannelSftp getChannelSftp() throws Exception {
//
//        if (channelSftp != null) {
//            if (channelSftp.isClosed()) {
//                channelSftp.connect();
//                return channelSftp;
//            }
//            return channelSftp;
//        } else {
//            Session sshSession = JschUtil.getSession(HOST, PORT, USERNAME, PASSWORD);
//            channelSftp = JschUtil.openSftp(sshSession);
//            return channelSftp;
//        }
//    }

    public  ChannelSftp getChannelSftp() throws Exception {

         sshSession = JschUtil.getSession(HOST, PORT, USERNAME, PASSWORD);

        return JschUtil.openSftp(sshSession);
    }


    public void logoutSftp() {
        try {
            if (channelSftp == null) {
                return;
            }
            if (channelSftp.isConnected()) {
                channelSftp.disconnect();
            }
            if (channelSftp.getSession() != null) {
                channelSftp.getSession().disconnect();
            }
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }

}
