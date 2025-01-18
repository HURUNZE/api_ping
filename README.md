🚀 API Ping 项目
一个炫酷的 Ping API，获取服务器信息和延迟

GitHub stars
GitHub forks
GitHub issues
GitHub license

🌟 特点
获取服务器公网IP地址

获取服务器地理位置信息

测量服务器响应时间

优雅的JSON格式返回

🛠 安装
1. 克隆仓库
bash
复制
git clone https://github.com/HURUNZE/api_ping.git
2. 上传到你的服务器
将 api.php 文件上传到你的 Web 服务器根目录。

3. 配置 Web 服务器
确保你的 Web 服务器（如 Apache 或 Nginx）配置正确，允许访问该文件。

🚀 使用
示例请求
bash
复制
curl http://yourdomain.com/api.php?site=https://www.example.com
示例响应
json
复制
{
    "ip": "198.51.100.1",
    "response_time": 0.0567,
    "location": {
        "country": "中国",
        "region": "广东省",
        "city": "广州市"
    }
}
📚 支持的请求
GET /api.php
参数
参数名	类型	必选	描述
site	string	是	目标网站的URL
响应
字段名	类型	描述
ip	string	目标网站的IP地址
response_time	float	服务器到目标网站的响应时间（秒）
location	object	目标网站的地理位置信息
location.country	string	国家
location.region	string	地区
location.city	string	城市
🛑 错误处理
状态码	错误信息	描述
400	Missing parameter: site	缺少必选参数 site
400	Invalid parameter: site	参数 site 格式错误
405	Method Not Allowed	只支持 GET 请求
500	Failed to retrieve server information	无法获取服务器信息
500	Invalid response from server information API	服务器信息API响应无效
📜 许可证
本项目遵循 MIT 许可证。

💡 感谢
特别感谢 ip-api.com 提供的IP和地理位置API服务。

🤝 贡献
欢迎 fork 和 PR！如果你有任何好的想法或建议，欢迎在 Issues 中提出。
