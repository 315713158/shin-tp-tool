<?php
/**
 * Author: ShinChen
 * Email:  shinchen_php@163.com
 * Create_Date: 2018/11/13/19:58
 */

namespace Shin\Tool\Token;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;


class Token
{

    /**
     * key
     *
     * @var bool|string
     */
    protected $key;

    /**
     * 允许令牌过期时间
     *
     * @var
     */
    protected $accessTokenExpired;

    /**
     * 刷新令牌过期时间
     *
     * @var
     */
    protected $refreshTokenExpired;


    /**
     * 初始化配置
     *
     * Token constructor.
     */
    public function __construct()
    {
        $this->key = file_get_contents(APP_PATH . '/key');

        $this->accessTokenExpired = time() + 7200;

        $this->refreshTokenExpired = time() + 1296000;
    }

    /**
     * 创建Token
     *
     * @param array $userInfo
     * @return array
     */
    public function createToken(array $userInfo)
    {
        $accessToken = [
            'iat' => time(), //签名时间
            'data' => $userInfo, //数据
            'exp' => $this->accessTokenExpired,//过期时间 //2 hour
        ];

        $refreshToken = [
            'iat' => time(), //签名时间
            'data' => $userInfo, //数据
            'exp' => $this->refreshTokenExpired,//过期时间 //1 month
        ];

        return [
            'access_token' => JWT::encode($accessToken, $this->key),
            'refresh_token' => JWT::encode($refreshToken, $this->key),
            'type' => 'bearer',
            'nick_name' => $userInfo['nick_name'],
        ];
    }

    /**
     * TODO 错误抓取
     *
     * @param string $accessToken
     * @return array
     */
    public function getAdminInfo(string $accessToken): array
    {
        try {
            return (array)JWT::decode($accessToken, $this->key, ['HS256']);
        } catch (ExpiredException $e) {
            #过期处理
            abort(401, '令牌过期');
        } catch (SignatureInvalidException $s) {
            #签名错误处理
            abort(401, '签名错误');
        } catch (\Exception $e) {
            #其他错误处理
            abort(501, '服务器繁忙');
        }
    }

    /**
     * 刷新令牌
     *
     * @param $refreshToken
     * @return array
     */
    public function refreshToken($refreshToken)
    {
        try {
            $items = (array)JWT::decode($refreshToken, $this->key, ['HS256']);
        } catch (ExpiredException $e) {
            #过期处理
            abort(401, '令牌过期');
        } catch (SignatureInvalidException $s) {
            #签名错误处理
            abort(401, '签名错误');
        } catch (\Exception $e) {
            #其他错误处理
            abort(501, '服务器繁忙');
        }

        $accessToken = [
            'iat' => time(), //签名时间
            'data' => $items['data'], //数据
            'exp' => $this->accessTokenExpired,//过期时间 //2 hour
        ];

        return [
            'access_token' => JWT::encode($accessToken, $this->key),
            'type' => 'bearer'
        ];
    }

}