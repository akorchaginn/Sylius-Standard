<?php declare(strict_types=1);

namespace AppBundle\Provider;

use Doctrine\Common\Collections\Collection;
use SitemapPlugin\Factory\SitemapUrlFactoryInterface;
use SitemapPlugin\Model\ChangeFrequency;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use AppBundle\Repository\StaticContentInterface;
use Symfony\Component\Routing\RouterInterface;

use SitemapPlugin\Provider\UrlProviderInterface;
/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 * @author Stefan Doorn <stefan@efectos.nl>
 */
final class StaticContentUrlProvider implements UrlProviderInterface
{
    /**
     * @var EntityRepository
     */
    private $staticRepository;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var SitemapUrlFactoryInterface
     */
    private $sitemapUrlFactory;

    /**
     * @var array
     */
    private $urls = [];
    
    /**
     * @param EntityRepository $staticRepository
     * @param RouterInterface $router
     * @param SitemapUrlFactoryInterface $sitemapUrlFactory
     */
    public function __construct(
        EntityRepository $staticRepository,
        RouterInterface $router,
        SitemapUrlFactoryInterface $sitemapUrlFactory
    ) {
        $this->staticRepository = $staticRepository;
        $this->router = $router;
        $this->sitemapUrlFactory = $sitemapUrlFactory;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'static_contents';
    }

    /**
     * {@inheritdoc}
     */
    
    /**
     * TODO: Переделать с поддержкой локали
     */
    public function generate(): iterable
    {
        $_locale = 'ru_RU';
        
        foreach ($this->getStatics() as $static) {
            $staticUrl = $this->sitemapUrlFactory->createNew();
            $staticUrl->setChangeFrequency(ChangeFrequency::always());
            $staticUrl->setPriority(0.5);
            $staticUrl->setLastModification($static->getUpdatedAt());
            $location = $this->router->generate('sylius_shop_static_content_slug_show', [
                    'slug' => $static->getSlug(),
                    '_locale' => $_locale
                ]);
            $staticUrl->setLocalization($location);
            $this->urls[] = $staticUrl;
        }

        return $this->urls;
    }

    /**
     * @return array|Collection|EntityRepository[]
     */
    private function getStatics(): iterable
    {
        return $this->staticRepository->createQueryBuilder('o')
            ->getQuery()
            ->getResult();
    }
}
