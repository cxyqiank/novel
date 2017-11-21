# novel
揽阅小说后台管理系统
1. 实现了基本管理员的添加登录。
2. 实现了前台banner和公告的管理
3. 实现了小说的上传，修改，查看，及小说章节的基本存储。
4. databaseUML 文件为基本数据库结构。
5. 使用laravel 5.4自带的数据库迁移。
6. 前台功能正在完善。
### 在项目中用到触发器如下
CREATE TRIGGER novel_hot
AFTER INSERT ON novels
FOR EACH ROW 
BEGIN
  INSERT INTO hots(novel_id,visitors,collectors) VALUES(NEW.id,RAND()*100,RAND()*100);
END

