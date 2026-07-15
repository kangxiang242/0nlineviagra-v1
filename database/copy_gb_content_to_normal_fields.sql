-- Run this before removing *_gb fields from the admin/database.
-- It copies non-empty Googlebot SEO content into the normal fields used by the live templates.

START TRANSACTION;

UPDATE configs AS normal
JOIN configs AS googlebot
  ON googlebot.name = CONCAT(normal.name, '_gb')
SET normal.content = googlebot.content,
    normal.updated_at = NOW()
WHERE normal.name IN (
    'home_lilly_about_title',
    'home_lilly_about_desc',
    'home_health_about_title',
    'home_health_about_desc',
    'advs_title',
    'home_diversified_about_title',
    'home_diversified_about_desc',
    'home_news_about_title',
    'home_news_about_desc'
)
  AND googlebot.content IS NOT NULL
  AND googlebot.content <> '';

UPDATE article_cates
SET name = name_gb,
    updated_at = NOW()
WHERE name_gb IS NOT NULL
  AND name_gb <> '';

UPDATE categories
SET `describe` = describe_gb,
    updated_at = NOW()
WHERE describe_gb IS NOT NULL
  AND describe_gb <> '';

UPDATE categories
SET `describe2` = describe2_gb,
    updated_at = NOW()
WHERE describe2_gb IS NOT NULL
  AND describe2_gb <> '';

UPDATE faqs
SET questions = questions_gb,
    updated_at = NOW()
WHERE questions_gb IS NOT NULL
  AND questions_gb <> '';

UPDATE faqs
SET answers = answers_gb,
    updated_at = NOW()
WHERE answers_gb IS NOT NULL
  AND answers_gb <> '';

UPDATE navigations
SET name = name_gb,
    updated_at = NOW()
WHERE name_gb IS NOT NULL
  AND name_gb <> '';

UPDATE pages
SET title = title_gb,
    updated_at = NOW()
WHERE title_gb IS NOT NULL
  AND title_gb <> '';

UPDATE configs
SET content = '性健康知識分享｜輝瑞威而鋼不斷提高不同族群的性健康品質',
    updated_at = NOW()
WHERE name IN ('home_diversified_about_title', 'home_diversified_about_title_gb');

UPDATE configs
SET content = '訂購威而鋼壯陽藥｜強力增強陰莖勃起硬度，親密時刻持久堅挺',
    updated_at = NOW()
WHERE name IN ('advs_title', 'advs_title_gb');

UPDATE pages
SET title = '性健康知識',
    title_gb = '性健康知識',
    updated_at = NOW()
WHERE uri = 'sexual-health';

UPDATE navigations
SET name = '性健康知識',
    name_gb = '性健康知識',
    updated_at = NOW()
WHERE id IN (6, 18);

UPDATE seos
SET title = CASE id
    WHEN 1 THEN '威而鋼壯陽藥線上訂購官網｜陰莖勃起更硬・親密更自信'
    WHEN 2 THEN '威而鋼壯陽藥100mg訂購｜陰莖勃起增大硬挺・親密激情加分'
    WHEN 3 THEN '威而鋼壯陽藥50mg訂購｜陰莖勃起堅挺有力・親密幸福感提升'
    WHEN 4 THEN '威而鋼壯陽藥25mg訂購｜輔助陰莖勃起・提高親密表現'
    WHEN 5 THEN '威而鋼線上訂購全攻略，助你親密無障礙'
    WHEN 6 THEN '威而鋼官網嚴格保護隱私，讓你安心購買不擔心'
    WHEN 7 THEN '威而鋼官網售後服務完善，保障你的親密品質'
    WHEN 8 THEN '威而鋼訂單追蹤，確保商品及時到達'
    WHEN 9 THEN '了解勃起障礙，威而鋼助你重拾親密自信'
    WHEN 10 THEN '深入解析威而鋼作用機轉，讓親密更順利自然'
    WHEN 12 THEN '威而鋼用法功效詳解，助你親密更有自信'
    WHEN 13 THEN '了解威而鋼副作用，讓使用更安全放心'
    WHEN 14 THEN '威而鋼服用禁忌，確保親密安全無虞'
    WHEN 15 THEN '威而鋼常見問題解答，解除用藥疑慮'
    WHEN 16 THEN '威而鋼官網親密技巧分享，增進性愛健康'
    WHEN 17 THEN '威而鋼使用心得分享，提升你的親密自信'
    WHEN 18 THEN '了解威而鋼官網，專注提升你的親密品質'
    WHEN 19 THEN '聯絡威而鋼客服，解答你親密相關疑問'
    ELSE title
END,
    updated_at = NOW()
WHERE id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16, 17, 18, 19);

UPDATE categories
SET describe2 = CASE id
    WHEN 1 THEN '陰莖增大勃起硬挺｜親密時刻更有自信'
    WHEN 2 THEN '陰莖勃起堅挺有力｜提升親密幸福感'
    WHEN 3 THEN '輔助陰莖勃起｜提升親密表現'
    ELSE describe2
END,
    describe2_gb = CASE id
    WHEN 1 THEN '陰莖增大勃起硬挺｜親密時刻更有自信'
    WHEN 2 THEN '陰莖勃起堅挺有力｜提升親密幸福感'
    WHEN 3 THEN '輔助陰莖勃起｜提升親密表現'
    ELSE describe2_gb
END,
    updated_at = NOW()
WHERE id IN (1, 2, 3);

UPDATE pages
SET title = '威而鋼正品壯陽藥線上訂購｜增強陰莖勃起能力',
    title_gb = '威而鋼正品壯陽藥線上訂購｜增強陰莖勃起能力',
    updated_at = NOW()
WHERE id = 31;

UPDATE faqs
SET questions = '日常生活中有哪些可以提升親密能力的技巧？',
    questions_gb = '日常生活中有哪些可以提升親密能力的技巧？',
    updated_at = NOW()
WHERE id = 3;

UPDATE faqs
SET answers = '不建議自行長期服用威而鋼Viagra。儘管威而鋼被證實是安全且有效，並且沒有依賴性，但長期服用可能增加副作用以及肝臟、腎臟負擔，特別是超劑量服用時。若需要長期治療ED，應先諮詢醫師或藥師評估更合適的用藥方案。',
    answers_gb = '不建議自行長期服用威而鋼Viagra。儘管威而鋼被證實是安全且有效，並且沒有依賴性，但長期服用可能增加副作用以及肝臟、腎臟負擔，特別是超劑量服用時。若需要長期治療ED，應先諮詢醫師或藥師評估更合適的用藥方案。',
    updated_at = NOW()
WHERE id = 11;

UPDATE articles
SET title = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(title, '犀利士', '其他同類藥物'), 'Cialis', '其他同類藥物'), 'cialis', '其他同類藥物'), '樂威壯', '其他同類藥物'), '乐威壮', '其他同類藥物'), 'Levitra', '其他同類藥物'), 'levitra', '其他同類藥物'),
    brief = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(brief, '犀利士', '其他同類藥物'), 'Cialis', '其他同類藥物'), 'cialis', '其他同類藥物'), '樂威壯', '其他同類藥物'), '乐威壮', '其他同類藥物'), 'Levitra', '其他同類藥物'), 'levitra', '其他同類藥物'),
    content = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(content, '犀利士', '其他同類藥物'), 'Cialis', '其他同類藥物'), 'cialis', '其他同類藥物'), '樂威壯', '其他同類藥物'), '乐威壮', '其他同類藥物'), 'Levitra', '其他同類藥物'), 'levitra', '其他同類藥物'),
    img_alt = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(img_alt, '犀利士', '其他同類藥物'), 'Cialis', '其他同類藥物'), 'cialis', '其他同類藥物'), '樂威壯', '其他同類藥物'), '乐威壮', '其他同類藥物'), 'Levitra', '其他同類藥物'), 'levitra', '其他同類藥物'),
    seo_title = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(seo_title, '犀利士', '其他同類藥物'), 'Cialis', '其他同類藥物'), 'cialis', '其他同類藥物'), '樂威壯', '其他同類藥物'), '乐威壮', '其他同類藥物'), 'Levitra', '其他同類藥物'), 'levitra', '其他同類藥物'),
    seo_keyword = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(seo_keyword, '犀利士', '其他同類藥物'), 'Cialis', '其他同類藥物'), 'cialis', '其他同類藥物'), '樂威壯', '其他同類藥物'), '乐威壮', '其他同類藥物'), 'Levitra', '其他同類藥物'), 'levitra', '其他同類藥物'),
    seo_description = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(seo_description, '犀利士', '其他同類藥物'), 'Cialis', '其他同類藥物'), 'cialis', '其他同類藥物'), '樂威壯', '其他同類藥物'), '乐威壮', '其他同類藥物'), 'Levitra', '其他同類藥物'), 'levitra', '其他同類藥物'),
    updated_at = NOW()
WHERE CONCAT_WS(' ', title, brief, content, seo_title, seo_keyword, seo_description, img_alt) REGEXP '犀利士|樂威壯|乐威壮|Cialis|Levitra|禮來|拜耳';

COMMIT;
